<?php
/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 3/26/17
 * Time: 3:27 PM
 */

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Services\AddressTranslationService;
use App\Services\GPSTranslationService;
use App\Services\MockGPSTranslationService;
use App\Services\RCOTranslationService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class RCOSearchController extends Controller
{
    public function __construct()
    {
        $this->service = new AddressTranslationService();
    }

    public function get($id)
    {
        return response()->json(Organization::find($id)->load(['committees', 'socialMedia']));
    }
    public function search($address = null)
    {
        $organizations = null;
        $address = $address ?? Input::get('address');
        if (strlen($address) > 0) {
            try {
                $organizations = $this->service->getRCOListForAddress($address);
            } catch (Exception $e) {
                dd("Woops! An error occured.  Information: ", $e);
            }
        }
        return response()->json($organizations);
    }
    public function all()
    {
        $rcos = $this->service->rcoService->getAllRCOs();
        return response()->json($rcos);
    }
}