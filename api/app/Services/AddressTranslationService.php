<?php
namespace App\Services;


use App\Services\GPS\GPSTranslationService;
use App\Services\RCO\RCOTranslationService;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * This service packages and combined the functionality of two other services for a
 * cleaner interaction with the rest of the application
 */
class AddressTranslationService
{
    protected $gpsService;

    protected $rcoService;

    public function __construct()
    {
        $this->gpsService = App::make('GPSTranslationService');
        $this->rcoService = App::make('RCOTranslationService');
    }
    /**
     * Given an address, we want to know all of the RCO's that apply to that location.
     *
     * @param string $address The address that we want to find RCO's for
     * @return Collection|void All of the RCO's that fit the address
     * @throws Exception If either subservice throws an exception, that should be passed along
     */
    public function getRCOListForAddress(string $address): Collection
    {
        $coordinates  = null;

        try {
            $coordinates = $this->gpsService->getGPSFromAddress($address);
            $organizations = $this->rcoService->getRCOListForGPS($coordinates);
            return $organizations;
        } catch (Exception $e) {
            // An error occured and we should find a good way to show that to the user.
            throw $e;
        }
    }
}