<?php
/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 4/20/17
 * Time: 6:30 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SurveyToken extends Model
{
    protected $table = 'survey_tokens';

    public $primaryKey  = 'token';

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}