<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    public function committees()
    {
        return $this->hasMany('App\Models\Committee');
    }

    public function socialMedia()
    {
        return $this->hasMany('App\Models\SocialMedia');
    }

    public function getMedia($type)
    {
        foreach ($this->socialMedia as $media) {
            if (strtolower($media->type) === strtolower($type)) {
                return $media;
            }
        }
        return null;
    }

    public function setMedia($type, $value)
    {
        $media = $this->getMedia($type);
        if (!$media) {
            $media = new SocialMedia();
            $media->organization_id = $this->id;
        }
        $media->type = $type;
        $media->handle = $value;
        $media->save();
        return $media;
    }
}