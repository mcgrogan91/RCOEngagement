<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: kmcgrogan
 * Date: 4/13/17
 * Time: 10:08 PM
 */
class SocialMedia extends Model
{

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}