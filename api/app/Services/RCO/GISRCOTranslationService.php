<?php
namespace App\Services\RCO;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;
use stdClass;

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

        $api = env('RCO_API_ADDRESS');
        if (!$api) {
            throw new Exception('RCO_API_ADDRESS not set up: See documentation for setup under External Resources');
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $api,
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        try {
            $queryParams = [
                'where' => '1=1',
                'geometry' => '{"y":"'.$coordinates->latitude.'","x":"'.$coordinates->longitude.'"}',
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
                'f' => 'json',
            ];
            /** @var ResponseInterface $response */
            $response = $client->get('0/query', [
                'query' => $queryParams
            ]);

            if ($response->getStatusCode() === 200) {
                $json = json_decode($response->getBody()->getContents());

                foreach ($json->features as $rco) {
                    $rcos[] = $rco->attributes;
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