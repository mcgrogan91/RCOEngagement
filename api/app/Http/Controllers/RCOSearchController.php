<?php
/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 3/26/17
 * Time: 3:27 PM
 */

namespace App\Http\Controllers;

use App\Services\GPSTranslationService;
use Illuminate\Support\Facades\Input;

class RCOSearchController extends Controller
{

    public function search()
    {
        $rcos = collect(['Hello', 'World']);

        if ($address = Input::get('address')) {
            try {
                $coordinates = GPSTranslationService::TranslationService::getGPSFromAddress($address);
            } catch (Exception $e) {
                dd($e);
            }
            
            return $coordinates;
        }

        return response()->json($rcos);
    }
}