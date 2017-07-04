<?php
namespace App\Observers;

use App\Mail\OrganizationCreated;
use App\Models\Organization;
use App\Models\SurveyToken;
use Illuminate\Support\Facades\Mail;

/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 5/9/17
 * Time: 6:42 PM
 */
class OrganizationObserver
{

    /**
     * Listen to the Organization created event.
     *
     * @param  Organization  $organization
     * @return void
     */
    public function created(Organization $organization)
    {
        $token = new SurveyToken();
        $token->organization_id = $organization->id;
        $token->token = str_random(50);
        $token->save();
        if ($organization->PRIMARY_EMAIL) {
            Mail::to($organization->PRIMARY_EMAIL)->send(new OrganizationCreated($organization));
        } else if ($organization->ALTERNATE_EMAIL) {
            Mail::to($organization->ALTERNATE_EMAIL)->send(new OrganizationCreated($organization));
        } else {
            error_log("Was unable to send an email for token: ". $token->token);
        }

    }
}
