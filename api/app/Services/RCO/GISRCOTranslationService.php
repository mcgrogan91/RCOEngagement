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
        $coordinatePoint = sprintf('POINT(%s %s)', $coordinates->latitude, $coordinates->longitude);
        $organizations = Organization::whereRaw("Contains(polygon, GeomFromText('$coordinatePoint'))")->get();
        
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

    /**
     * Given the local ID for an RCO, get any information that should be associated with it
     * @param  int    $id The ID of the object we're looking for
     * @return stdClass     The description of the RCO
     */
    public function getRCO(int $id): stdClass
    {
        $rco = null;

        if (!Cache::has("rco_$id")) {
            $api = env('RCO_API_ADDRESS');
            if (!$api) {
                throw new Exception('RCO_API_ADDRESS not set up: See documentation for setup under External Resources');
            }

            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => $api
            ]);
            $rco = Organization::find($id);
            try {
                set_time_limit(0);
                $queryParams = [
                    'where' => "ORGANIZATION_NAME='".$rco->name."'",
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
                    $json = json_decode($response->getBody()->getContents());
                    foreach ($json->features as $rco) {
                        $current = $rco->properties;
                        $current->geometry = $rco->geometry;
                        $current = $this->sanitizeRCO($current);
                        Cache::put("rco_".$current->id, $current, Carbon::today()->endOfDay());
                        $rco = $current;
                    }
                } else {
                    // We didn't get a success, handle exception
                    throw $this->generateException($response);
                }
            } catch (Exception $e) {
            // Something bad happened during the
            throw $e;
            }
        } else {
            $rco = Cache::get("rco_$id");
        }
        return $rco;
    }
    
    protected function toSystemRCO($json) {
        $new = false;
        // $current = $rco->properties;
        // $current->geometry = $rco->geometry;
        $rco = Organization::where('name', $json->properties->ORGANIZATION_NAME)->first();
        if (!$rco) {
            $new = true;
            $rco = new Organization();
            $rco->name = $json->properties->ORGANIZATION_NAME;
        }

        $rco->last_response = json_encode($json);
        $rco->polygon = Organization::convertGeoPolygon(json_encode($json->geometry->coordinates[0]));
        $rco->save();


        if ($new === true) {
            // TODO move this into an event
            $token = new SurveyToken();
            $token->organization_id = $rco->id;
            $token->token = str_random(50);
            $token->save();
            // Send out email with survey link
        }

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