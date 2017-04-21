<?php
/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 4/20/17
 * Time: 6:31 PM
 */

namespace App\Http\Controllers;


use App\Models\SurveyToken;

class SurveyController
{

    public function get($token)
    {
        $survey = SurveyToken::where('token', $token)->first();

        if ($survey) {
            return view('survey', [
                'token' => $survey,
                'rco' => $survey->organization
            ]);
        }
    }

    public function store()
    {
        //$survey = SurveyToken::where('token', $token)->first();
    }
}