<?php
/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 4/20/17
 * Time: 6:31 PM
 */

namespace App\Http\Controllers;


use App\Models\Committee;
use App\Models\SurveyToken;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

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

    public function store($token)
    {
        if (Request::get('_token') === csrf_token()) {
            $survey = SurveyToken::where('token', $token)->first();
            if ($survey && !$survey->used) {
                $org = $survey->organization;
                if (Request::get('mission_statement')) {
                    $org->mission_statement = Request::get('mission_statement');
                }
                if ($medias = Request::get('social_media')) {
                    foreach ($medias as $type => $media) {
                        if (!$media) {
                            $current = $org->getMedia(ucfirst($type));
                            if ($current) {
                                $current->delete();
                            }
                        } else {
                            $org->setMedia(ucfirst($type), $media);
                        }

                    }
                }

                $org->committees()->delete();
                if ($committees = Request::get('committees')) {
                    foreach ($committees as $committee) {
                        if ($committee) {
                            $newCommittee = new Committee();
                            $newCommittee->organization_id = $org->id;
                            $newCommittee->name = $committee;
                            $newCommittee->save();
                        }
                    }
                }
                $org->save();

                $survey->used = true;
                $survey->save();
            }
        }

        Session::flash('success', "Thank you for updating your Registered Community Organization Information!");
        return redirect()->back();
    }
}