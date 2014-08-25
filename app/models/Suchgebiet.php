<?php

class Suchgebiet extends Eloquent
{
    public $ansprechpartner = null;

    protected $table = 'suchgebiet';

    protected $fillable = array('name', 'beschreibung', 'treffpunkt', 'created_at', 'updated_at');

    // funktion darf nicht heißen, wie Tabellenspalte, deswegen "adresse"
    public function adresse()
    {
        return $this->belongsTo('Adresse', 'treffpunkt', 'id');
    }

    /*
    public function koordinaten()
    {
        return $this->belongsToMany('Koordinate', 'suchgebiet_hat_koordinaten', 'suchgebiet_id', 'koordinate_id');
    }
    */

    public function flaechen()
    {
        return $this->hasMany('Flaeche', 'suchgebiet_id');
    }

    public function personen()
    {
        return $this->hasMany('Person', 'suchgebiet_id');
    }

    public function landschaftseigenschaften()
    {
        return $this->belongsToMany(
            'Eigenschaft', 
            'suchgebiet_eigenschaft',
            'suchgebiet_id',
            'eigenschaft_id');
    }

    public function eigenschaftenAsString($delimiter = ', ')
    {
        return join($delimiter, $this->landschaftseigenschaften->map(function($eigenschaft) {
            return $eigenschaft->name;
        })->toArray());
    }

    public function getAnsprechpartner()
    {
        if(!isset($this->ansprechpartner)) {
            $this->ansprechpartner = $this->personen()->whereTyp('Ansprechpartner')->first();
            //$ansprechpartner = $this->personen()->whereTyp('Ansprechpartner')->first();
        }

        return $this->ansprechpartner;
        //return $ansprechpartner;
    }

    public function hatAnsprechpartner() 
    {
        return null !== $this->getAnsprechpartner();
    }

    public function getArea()
    {
        // Proposal:
//        return $this->flaechen
//                ->map(function($flaeche) { return geoPHP::load($flaeche->polygon, 'wkt'); })
//                ->reduce(function($area, $flaeche) {
//                    $polygon->setSRID(4326);
//                    return $area + $polygon->getArea();
//                });

        $area = 0;
        foreach ($this->flaechen as $flaeche)
        {
            $wktPolygon = $flaeche->polygon;
            $polygon = geoPHP::load($wktPolygon,'wkt');
            $polygon->setSRID(4326);
            $area += $polygon->getArea();
        }
        return $area;
    }

    /**
     * Liefert ein JSON Array aus geoJSON kodierten Flaechen (Polygone) 
     * 
     * @param Suchgebiet $suchgebiet das Suchgebiet Model
     * 
     * @return Suchgebiet
     */
    public function ladeFlaechenAsGeoJson()
    {
        $flaechen = array();
        foreach ($this->flaechen as $flaeche)
        {
            $wktPolygon = $flaeche->polygon;
            $polygon = geoPHP::load($wktPolygon,'wkt');
            $geoJsonObj = json_decode($polygon->out('json'));
            array_push($flaechen, $geoJsonObj);
        }

        if (sizeof($flaechen) < 1)
            return null;

        return json_encode($flaechen);
    }

    public function getBoundingBox()
    {
        // Proposal:
//        return $this->flaechen
//                ->map(function($flaeche) { return $flaeche->polygon; })
//                ->map(function($polygon) { return geoPHP::load($polygon, 'wkt'); })
//                ->map(function($polygon) { return $polygon->getBBox(); })
//                ->first(); // Liefert null zurück, wenn nicht gefunden.

        if (sizeof($this->flaechen) > 0)
        {
            $polygons = array();

            foreach ($this->flaechen as $flaeche)
            {
                $wktPolygon = $flaeche->polygon;
                $polygon = geoPHP::load($wktPolygon,'wkt');

                array_push($polygons, $polygon);
            }


            //$multipolygon = new geoPHP::MultiPolygon($polygons);
            $boundingBox = $polygons[0]->getBBox();

            return $boundingBox;
        }
        else
            return null;
    }
}
