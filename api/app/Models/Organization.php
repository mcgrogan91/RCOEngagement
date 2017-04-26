<?php
namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{

    /**
     * The attributes that hold geometrical data.
     *
     * @var array
     */
    protected $geometry = array('geometry');

    /**
     * Select geometrical attributes as text from database.
     *
     * @var bool
     */
    protected $geometryAsText = true;

    protected $appends = [
        'ORGANIZATION_NAME',
        'ORGANIZATION_ADDRESS',
        'MEETING_LOCATION_ADDRESS',
        'ORG_TYPE',
        'PREFFERED_CONTACT_METHOD',
        'PRIMARY_NAME',
        'PRIMARY_ADDRESS',
        'PRIMARY_EMAIL',
        'PRIMARY_PHONE',
        'P_PHONE_EXT',
        'ALTERNATE_NAME',
        'ALTERNATE_ADDRESS',
        'ALTERNATE_EMAIL',
        'ALTERNATE_PHONE',
        'A_PHONE_EXT',
        'EXPIRATIONYEAR',
        'EFFECTIVE_DATE',
        'geometry'
    ];

    protected $hidden = [
        'name',
        'last_response',
        'last_response_at',
        'created_at',
        'updated_at'
    ];

    public function getOrganizationNameAttribute()
    {
        return $this->last_response->properties->ORGANIZATION_NAME;
    }

    public function getOrganizationAddressAttribute()
    {
        return $this->last_response->properties->ORGANIZATION_ADDRESS;
    }

    public function getMeetingLocationAddressAttribute()
    {
        return $this->last_response->properties->MEETING_LOCATION_ADDRESS;
    }
    public function getOrgTypeAttribute()
    {
        return $this->last_response->properties->ORG_TYPE;
    }
    public function getPrefferedContactMethodAttribute()
    {
        return $this->last_response->properties->PREFFERED_CONTACT_METHOD;
    }
    public function getPrimaryNameAttribute()
    {
        return $this->last_response->properties->PRIMARY_NAME;
    }
    public function getPrimaryAddressAttribute()
    {
        return $this->last_response->properties->PRIMARY_ADDRESS;
    }
    public function getPrimaryEmailAttribute()
    {
        return $this->last_response->properties->PRIMARY_EMAIL;
    }
    public function getPrimaryPhoneAttribute()
    {
        return $this->last_response->properties->PRIMARY_PHONE;
    }
    public function getPPhoneExtAttribute()
    {
        return $this->last_response->properties->P_PHONE_EXT;
    }
    public function getAlternateNameAttribute()
    {
        return $this->last_response->properties->ALTERNATE_NAME;
    }
    public function getAlternateAddressAttribute()
    {
        return $this->last_response->properties->ALTERNATE_ADDRESS;
    }
    public function getAlternateEmailAttribute()
    {
        return $this->last_response->properties->ALTERNATE_EMAIL;
    }
    public function getAlternatePhoneAttribute()
    {
        return $this->last_response->properties->ALTERNATE_PHONE;
    }
    public function getAPhoneExtAttribute()
    {
        return $this->last_response->properties->A_PHONE_EXT;
    }
    public function getExpirationyearAttribute()
    {
        return $this->last_response->properties->EXPIRATIONYEAR;
    }
    public function getEffectiveDateAttribute()
    {
        return Carbon::createFromTimestamp($this->last_response->properties->EFFECTIVE_DATE / 1000)->toDateTimeString();
    }

    public function getLastResponseAttribute($last_response)
    {
        return json_decode($last_response);
    }

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

    public function getGeometryAttribute($geometry)
    {
        return json_decode($this->attributes['geometry']);
    }
    public function setGeometryAttribute($json)
    {
        $this->attributes['geometry'] = DB::raw("ST_GeomFromGeoJSON('$json')");
    }

    /**
     * Get a new query builder for the model's table.
     * Manipulate in case we need to convert geometrical fields to text.
     *
     * @param  bool  $excludeDeleted
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery($excludeDeleted = true)
    {
        if (!empty($this->geometry) && $this->geometryAsText === true)
        {
            $raw = '';
            foreach ($this->geometry as $column)
            {
                $raw .= 'ST_AsGeoJSON(`' . $this->table . '`.`' . $column . '`) as `' . $column . '`, ';
            }
            $raw = substr($raw, 0, -2);
            return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw($raw));
        }
        return parent::newQuery($excludeDeleted);
    }
}