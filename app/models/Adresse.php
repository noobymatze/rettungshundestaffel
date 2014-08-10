<?php

class Adresse extends Eloquent
{
    protected $table = 'adresse';

    public $timestamps = false;

    protected $fillable = array('strasse', 'hausnummer', 'zusatz', 'ort', 'postleitzahl', 'koordinate');

    /**
     * Get-Accessor zum auslesen des Feldes "koordinate" vom Typ POINT
     * 
     * @return WKT-Repräsentation des Point
     * 
     */
    public function getKoordinateAttribute()
    {
        $id =  $this->attributes['id'];
        $wkt = DB::table('adresse')->find($id, array(DB::raw('AsText(koordinate) AS koordinate')))->koordinate;
        
        return $wkt;
    }

    /**
     * Set-Mutator zum setzten des Feldes "koordinate" vom Typ POINT
     * @param $value WKT-Repräsentation eines Point
     * 
     */
    public function setKoordinateAttribute($value)
    {
        $this->attributes['koordinate'] = DB::raw("PointFromText('" . $value . "')");
    }

    public function setHausnummerAttribute($value)
    {
        if ($value === '' || is_null($value))
            $this->attributes['hausnummer'] = null;
        else
            $this->attributes['hausnummer'] = $value;
    }
}
