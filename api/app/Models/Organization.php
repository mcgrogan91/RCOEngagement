<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{

    /**
     * The attributes that hold geometrical data.
     *
     * @var array
     */
    protected $geometry = array('polygon');

    /**
     * Select geometrical attributes as text from database.
     *
     * @var bool
     */
    protected $geometryAsText = true;

    //protected $appends = ['geometry'];

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

    public function getDisplayGeometry()
    {
        $result = $this->polygon;
        $result = str_replace(',', '],[', $result);
        $result = str_replace('((', '[[', $result);
        $result = str_replace('))', ']]', $result);
        $result = str_replace(' ', ',', $result);
        $result = str_replace('POLYGON', '', $result);
        return $result;
    }

    public static function convertGeoPolygon($polygon)
    {
        $polygon = preg_replace('/,(\d)/', ' $1', $polygon);
        $polygon = str_replace('],[', ',', $polygon);
        $polygon = str_replace('[[', '(', $polygon);
        $polygon = str_replace(']]', ')', $polygon);
        //$polygon = "POLYGON" . $polygon;
        return $polygon;
    }

    public function setPolygonAttribute($value) {
        $this->attributes['polygon'] = DB::raw("POLYGON($value)");
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
                $raw .= 'AsText(`' . $this->table . '`.`' . $column . '`) as `' . $column . '`, ';
            }
            $raw = substr($raw, 0, -2);
            return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw($raw));
        }
        return parent::newQuery($excludeDeleted);
    }
}