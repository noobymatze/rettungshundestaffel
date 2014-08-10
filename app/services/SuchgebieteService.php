<?php

/**
 * Dieser Service ist für alle Datenbankinteraktionen
 * für die Suchgebiete verantwortlich.
 */
class SuchgebieteService {

    const SEITEN_GROESSE = 9;

    /**
     * Liefert alle Suchgebiete mit der in SuchgebieteService::SEITEN_GROESSE,
     * definierten Pagination Konstante.
     *
     * @return Illuminate\Database\Eloquent\Collection Eine Collection von Suchgebieten.
     */
    public function all() 
    {
        return Suchgebiet::paginate(SuchgebieteService::SEITEN_GROESSE);
    }

	/**
	 * 
	 * @param array $suchgebiet
	 * @return {boolean}, true falls das Suchgebiet angelegt worden ist, ansonsten false.
	 */
	public function speichere($suchgebiet)
	{
        $suchgebiet->save();
	}

    /**
     * 
     * @param $suchgebiet
     * @param array $flaechen 
     * @return {boolean}, true falls die zugehörigen Flächen zum Suchgebiet angelegt worden sind, ansonsten false.
     */
    public function speichereZugehoerigeFlaechen($suchgebiet, $flaechen)
    {
        $suchgebiet->flaechen()->saveMany($flaechen);
    }

	/**
	 * Liefert ein Suchgebiet mit einer Id aus der Datenbank.
     * 
	 * @param int $id Die ID des Suchgebiets, das geladen werden soll.
     * 
	 * @return Suchgebiet 
	 */
    public function lade($id)
    {
        return Suchgebiet::find($id);
    }

    /**
     * Liefert ein Suchgebiet mit einem Namen aus der Datenbank.
     * 
     * @param string $name Der Name des Suchgebiets.
     * 
     * @return Suchgebiet 
     */
    public function ladeMitName($name)
    {
        return $suchgebiet = Suchgebiet::where('name', '=', $name)->first();
    }

    /**
     * Liefert ein JSON Array aus geoJSON kodierten Flaechen (Polygone) 
     * 
     * @param Suchgebiet $suchgebiet das Suchgebiet Model
     * 
     * @return Suchgebiet
     */
    public function ladeFlaechenAsGeoJson($suchgebiet)
    {
        $flaechen = array();
        foreach ($suchgebiet->flaechen as $flaeche)
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

    public function getBoundingBox($suchgebiet)
    {
        if (sizeof($suchgebiet->flaechen) > 0) 
        {
            $polygons = array();

            foreach ($suchgebiet->flaechen as $flaeche)
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
	
    /**
     * Löscht das Suchgebiet mit der gegebenen ID aus der Datenbank.
     * 
     * @param int $id Die ID.
     */
    public function loesche($id) 
    {
        Suchgebiet::destroy($id);
    }
}
