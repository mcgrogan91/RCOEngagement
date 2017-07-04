<?php
namespace App\Services\RCO;

use App\Models\SurveyToken;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;
use stdClass;

use App\Models\Organization;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
/**
 * This service interfaces with external API's that will allow it to convert a set of GPS coordinates
 * for a Philadelphia address into a set of Registered Community Organizations
 */
class GISRCOTranslationService implements RCOTranslationService
{
    /**
     * Given a specific point on a map, this method finds the Registered Community Organizations
     * that have that point within them by utilizing an external API
     *
     * @param stdClass $coordinates An object with 'latitude' and 'longitude' properties
     * @return Collection The set of Registered Community Organizations that a point belongs to
     * @throws Exception If the external service causes an issue
     */
    public function getRCOListForGPS(stdClass $coordinates): Collection
    {

        $rcos = [];
        $coordinatePoint = sprintf('POINT(%s %s)', $coordinates->longitude, $coordinates->latitude);
        $organizations = Organization::whereRaw("ST_CONTAINS(geometry, GeomFromText('$coordinatePoint', 4326))")->with(['committees', 'socialMedia'])->get();
        return $organizations;
    }

    /**
     * Returns all available Registered Community Organizations
     * TODO: Clean these methods up, they share a LOT of code
     * @return Collection The full set of RCO's
     */
    public function getAllRCOs(): Collection
    {
        $rcos = [];
        $api = env('RCO_API_ADDRESS');
        if (!$api) {
            throw new Exception('RCO_API_ADDRESS not set up: See documentation for setup under External Resources');
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $api
        ]);

        try {
            set_time_limit(0);
            $queryParams = [
                'where' => '1=1',
                'geometryType' => 'esriGeometryPoint',
                'inSR' => 4326,
                'spatialRel' => 'esriSpatialRelWithin',
                'resultType' => 'none',
                'distance' => '0.0',
                'units' => 'esriSRUnit_Meter',
                'returnGeodetic' => 'false',
                'outFields' => '*',
                'returnGeometry' => 'true',
                'returnCentroid' => 'false',
                'multipatchOption' => 'xyFootprint',
                'maxAllowableOffset' => '',
                'geometryPrecision' => '',
                'outSR' => 4326,
                'returnIdsOnly' => 'false',
                'returnCountOnly' => 'false',
                'returnExtentOnly' => 'false',
                'returnDistinctValues' => 'false',
                'orderByFields' => '',
                'groupByFieldsForStatistics' => '',
                'outStatistics' => '',
                'resultOffset' => '',
                'resultRecordCount' => '',
                'returnZ' => 'false',
                'returnM' => 'false',
                'quantizationParameters' => '',
                'sqlFormat' => 'none',
                'f' => 'pgeojson',
            ];
            /** @var ResponseInterface $response */
            $response = $client->get('0/query', [
                'query' => $queryParams
            ]);

            if ($response->getStatusCode() === 200) {
                $responseJson = $response->getBody()->getContents();
                $json = json_decode($responseJson);
                foreach ($json->features as $rco) {
                    $rcos[] = $current = $this->toSystemRCO($rco);
                }
            } else {
                // We didn't get a success, handle exception
                throw $this->generateException($response);
            }
                
        } catch (Exception $e) {
            // Something bad happened during the
            throw $e;
        }
        return collect($rcos);
    }

    protected function toSystemRCO($json) {
        // $current = $rco->properties;
        // $current->geometry = $rco->geometry;
        $rco = Organization::where('name', $json->properties->ORGANIZATION_NAME)->first();
        if (!$rco) {
            $rco = new Organization();
            $rco->name = $json->properties->ORGANIZATION_NAME;
        }

        $rco->last_response = json_encode($json);
        $rco->last_response_at = Carbon::now();
        $rco->geometry = json_encode($json->geometry);
        $rco->save();
        return $rco;
    }


    /**
     * There are a couple ways that the external API can respond which we should package up as our own errors.
     * This method provides that wrapper, converting Guzzle and API errors into internal exceptions.
     *
     * @param ResponseInterface $response   The Guzzle Response object.
     * @param stdClass|null     $content    An optional JSON representation of the Response content.
     *
     * @return Exception    The Exception that should be thrown
     */
    protected function generateException(ResponseInterface $response): Exception
    {
        $errorResponse = sprintf(
            "Response code: %s, Message: %s",
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
        return new Exception($errorResponse);
    }



}