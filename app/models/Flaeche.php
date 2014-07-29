<?php

class Flaeche extends Eloquent
{
    protected $table = 'flaeche';

    protected $fillable = array('polygon');

    public function suchgebiet()
    {
        return $this->belongsTo('Suchgebiet', 'suchgebiet_id');
    }

    /**
     * Get-Accessor zum auslesen des Feldes "polygon" vom Typ POLYGON
     * 
     * @return WKT-Repräsentation des Polygon
     * 
     */
    public function getPolygonAttribute()
    {
        $id =  $this->attributes['id'];
        $wkt = DB::table('flaeche')->find($id, array(DB::raw('AsText(polygon) AS polygon')))->polygon;
        
        return $wkt;
    }

    /**
     * Set-Mutator zum setzten des Feldes "polygon" vom Typ POLYGON
     * @param $value WKT-Repräsentation eines Polygon
     * 
     */
    public function setPolygonAttribute($value)
    {
        $this->attributes['polygon'] = DB::raw("PolygonFromText('" . $value . "')");
    }
}
