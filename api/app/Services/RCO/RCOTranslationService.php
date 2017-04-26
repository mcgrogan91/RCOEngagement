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
interface RCOTranslationService
{
    /**
     * Given a specific point on a map, this method finds the Registered Community Organizations
     * that have that point within them by utilizing an external API
     *
     * @param stdClass $coordinates An object with 'latitude' and 'longitude' properties
     * @return Collection The set of Registered Community Organizations that a point belongs to
     * @throws Exception If the external service causes an issue
     */
    public function getRCOListForGPS(stdClass $coordinates): Collection;

    /**
     * Returns all available Registered Community Organizations
     *
     * @return Collection The full set of RCO's
     */
    public function getAllRCOs(): Collection;
}