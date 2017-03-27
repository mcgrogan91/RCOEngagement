<?php
namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * This service interfaces with external API's that will allow it to convert a street address
 * into a set of GPS coordinates with a latitude and longitude.
 */
class GPSTranslationService
{

    /**
     * Converts a street address into GPS coordinates.  There are two environment variables that it looks for, which
     * might not be ideal.  It might be better to have this done during bootstrapping, but for now this service
     * isn't a true Service and this works.
     *
     * @param $address      The address to be turned into coordinates
     * @return object       A generic object with 'latitude' and 'longitude' attributes
     * @throws Exception    There are a couple reasons this service will throw an exception.
     *                      These should be broken out into actual exception objects, but for now this approach is fine.
     *                      The Application could be missing required config options, or the API service we
     *                      are using to convert the address might respond in an unexpected way.
     */
    public static function getGPSFromAddress($address): object
    {
        $coordinates = null;

        $api = env('AIS_API_ADDRESS');
        $key = env('GATEKEEPER_SECRET');
        if (!$key) {
            throw new Exception('GATEKEEPER_SECRET not set up: See documentation for setup under External Resources');
        }
        if (!$api) {
            throw new Exception('AIS_API_ADDRESS not set up: See documentation for setup under External Resources');
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $api,
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        try {
            $response = $client->get($address, [
                'query' => ['gatekeeperKey' => $key]
            ]);
            if ($response->getStatusCode() === 200) {
                $content = \GuzzleHttp\json_decode($response->getBody()->getContents());
                if (isset($content->status) && $content->status !== 200) {
                    // If the endpoint has been hit before and 404'd, it will return a 200 with a JSON status of 404
                    // Handle that as if it had been a 404 response.
                    throw AddressTranslationService::generateException($response, $content);
                } else {
                    $coordinates = AddressTranslationService::getCoordinatesFromContent($content);
                }
            } else {
                // We didn't get a success, handle exception
                throw AddressTranslationService::generateException($response);
            }
        } catch (ClientException $e) {
            // Something bad happened during the
            throw AddressTranslationService::generateException($e->getResponse());
        }

        return $coordinates;
    }

    /**
     * There are a couple ways that the external API can respond which we should package up as our own errors.
     * This method provides that wrapper, converting Guzzle and API errors into internal exceptions.
     *
     * @param $response         The Guzzle Response object.
     * @param null $content     An optional JSON representation of the Response content.
     * @return Exception        The Exception that should be thrown
     */
    static function generateException($response, $content = null): Exception
    {
        if ($content) {
            $errorResponse = sprintf(
                "Response code: %s, Message: %s",
                $content->status,
                $content->message
            );
        } else {
            $errorResponse = sprintf(
                "Response code: %s, Message: %s",
                $response->getStatusCode(),
                $response->getReasonPhrase()
            );
        }
        return new Exception($errorResponse);
    }

    /**
     * Strips out all of the extra information our external API gives us into just the GPS coordinates.
     *
     * @param $content  The Body of the response from our translation API
     * @return object   An object representation with 'latitude' and 'longitude' properties.
     */
    static function getCoordinatesFromContent($content): object
    {
        $coordinates = null;

        $raw = isset($content->features) ?
            count($content->features) > 0 ?
                $content->features[0]->geometry->coordinates : null
            : null;

        if ($raw !== null && count($raw) === 2) {
            $coordinates = (object)[
                'latitude' => $raw[1],
                'longitude' => $raw[0]
            ];
        }

        return $coordinates;
    }
}
