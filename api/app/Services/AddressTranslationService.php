<?php
namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 3/26/17
 * Time: 5:47 PM
 */
class AddressTranslationService
{


    static function getGPSFromAddress($address): array
    {
        $coordinates = $exception = null;

        $api = env('AIS_API_ADDRESS');
        $key = env('GATEKEEPER_SECRET');
        if (!$key) {
            throw new Exception('GATEKEEPER_SECRET not set up: See documentation for setup under External Resources');
        }
        if (!$api) {
            throw new Exception('AIS Service Address not set up: See documentation for setup under External Resources');
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
                    $exception = AddressTranslationService::generateException($response, $content);
                } else {
                    $coordinates = AddressTranslationService::getCoordinatesFromContent($content);
                }
            } else {
                // We didn't get a success, handle exception
                $exception = AddressTranslationService::generateException($response);
            }
        } catch (ClientException $e) {
            // Something bad happened during the
            $exception = AddressTranslationService::generateException($e->getResponse());
        }

        if ($exception) {
            throw $exception;
        }
        return $coordinates;
    }

    private static function generateException($response, $content = null)
    {
        if ($content) {
            $errorResponse = sprintf("Response code: %s, Message: %s", $content->status, $content->message);
        } else {
            $errorResponse = sprintf("Response code: %s, Message: %s", $response->getStatusCode(), $response->getReasonPhrase());
        }
        return new Exception($errorResponse);
    }

    private static function getCoordinatesFromContent($content)
    {
        $coordinates = null;

        $raw = isset($content->features) ?
            count($content->features) > 0 ?
                $content->features[0]->geometry->coordinates : null
            : null;

        if ($raw !== null && count($raw) === 2) {
            $coordinates = [
                'latitude' => $raw[1],
                'longitude' => $raw[0]
            ];
        }
        
        return $coordinates;
    }
}
