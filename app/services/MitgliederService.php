<?php

/**
 * Dieser Service ist für alle Datenbankinteraktionen
 * für die Mitglieder verantwortlich.
 */
class MitgliederService {

    /**
     * Authentifiziert ein Mitglied anhand der E-Mail
     * und des Passworts. Diese müssen gesetzt und 
     * validiert sein.
     *
     * @param {string} email Die E-Mail des Mitglieds.
     * @param {string} passwort Das Passwort des Mtiglieds.
     *
     * @return {boolean} true, wenn Authentifizierung erfolgreich, 
     * ansonsten false.
     */
    public function authenticate($email, $passwort) 
    {
        return Auth::attempt(array(
            'email' => $email, 
            // password, weil Laravel Auth-Treiber password und nicht passwort haben möchte
            'password' => $passwort 
        ), true);
    }

    /**
     * Liefert alle Mitglieder zurück. 
     * Für Pagination können der Start und das Limit 
     * festgelegt werden.
     *
     * @param {integer} start Ab welchem Mitglied.
     * @param {integer} limit Wie viele Mitglieder zurückgegeben werden sollen.
     */
    public function all($start = 0, $limit = FALSE) 
    {
        return Mitglied::all();
    }

    /**
     * Liefert alle Mitglieder bis auf einen zurück. 
     * Für Pagination können der Start und das Limit 
     * festgelegt werden.
     *
     * @param {integer} id des Users, der ausgeschlossen werden soll
     * @param {integer} start Ab welchem Mitglied.
     * @param {integer} limit Wie viele Mitglieder zurückgegeben werden sollen.
     */
    public function allExceptFor($id, $start = 0, $limit = FALSE) 
    {
        return Mitglied::whereNotIn('id', array($id))->get();
    }
	
	/**
	 * 
	 * @param array $mitglied
	 * @return {boolean}, falls das Mitglied angelegt worden ist, ansonsten false.
	 */
	public function erstelleMitglied($mitglied)
	{
		$mitglied['passwort'] = Hash::make($mitglied['passwort']);
		Mitglied::create($mitglied);
		return true;
	}
	
	/**
	 * Liefert eine Liste von 
	 * @param {string} suchbegriff Der Begriff, nach dem 
	 *
	 * @return {Collection} 
	 */
	public function sucheNachVornameOderNachname($suchbegriff)
	{
		$name = explode(' ', trim($suchbegriff));
		
		if (count($name) < 2) 
		{
			// Setze den Nachnamen ebenfalls auf $suchbegriff
			$name[] = $suchbegriff; 
		}
		
		return Mitglied
				::where('vorname', 'LIKE', '%'.$name[0].'%')
				->orWhere('nachname', 'LIKE', '%'.$name[1].'%')
				->orWhere('email', 'LIKE', '%'.$name[0].'%')
				->orWhere('telefon', 'LIKE', '%'.$name[0].'%')
				->get();
	}

	/**
	 * Liefert ein Mitglied mit einer Id aus der Datenbank.
	 * @param {long} die Mitglied-Id
	 * @return {Mitglied}
	 */
    public function holeMitglied($id)
    {
        return Mitglied::find($id);
    }

}
