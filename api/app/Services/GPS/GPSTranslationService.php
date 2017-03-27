<?php
/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 3/26/17
 * Time: 9:58 PM
 */

namespace App\Services\GPS;


use stdClass;

interface GPSTranslationService
{
    /**
     * Converts a street address into GPS coordinates.  There are two environment variables that it looks for, which
     * might not be ideal.  It might be better to have this done during bootstrapping, but for now this service
     * isn't a true Service and this works.
     *
     * @param $address string   The address to be turned into coordinates
     *
     * @return stdClass A generic object with 'latitude' and 'longitude' attributes
     * @throws Exception    There are a couple reasons this service will throw an exception.
     *                      These should be broken out into actual exception objects, but for now this approach is fine.
     *                      The Application could be missing required config options, or the API service we
     *                      are using to convert the address might respond in an unexpected way.
     */
    public function getGPSFromAddress(string $address): stdClass;
}