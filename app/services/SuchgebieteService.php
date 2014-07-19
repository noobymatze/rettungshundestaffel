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
	 * @return {boolean}, falls das Suchgebiet angelegt worden ist, ansonsten false.
	 */
	public function speichere($suchgebiet)
	{
        $suchgebiet->save();
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
     * Löscht das Suchgebiet mit der gegebenen ID aus der Datenbank.
     * 
     * @param int $id Die ID.
     */
    public function loesche($id) 
    {
        Suchgebiet::destroy($id);
    }
}
