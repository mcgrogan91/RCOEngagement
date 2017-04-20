<?php
/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 3/26/17
 * Time: 3:27 PM
 */

namespace App\Http\Controllers;

use App\Services\AddressTranslationService;
use App\Services\GPSTranslationService;
use App\Services\MockGPSTranslationService;
use App\Services\RCOTranslationService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class RCOSearchController extends Controller
{

    public function get($id)
    {
        dd($id);
    }
    public function search()
    {
        $organizations = null;

        if ($address = Input::get('address')) {
            try {
                $service = new AddressTranslationService();
                $organizations = $service->getRCOListForAddress($address);
            } catch (Exception $e) {
                dd("Woops! An error occured.  Information: ", $e);
            }
        }
        return response()->json($organizations);
    }
}