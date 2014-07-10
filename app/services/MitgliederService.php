<?php

/**
 * Dieser Service ist für alle Datenbankinteraktionen
 * für die Mitglieder verantwortlich.
 */
class MitgliederService {

    const SEITEN_GROESSE = 9;

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
     * Liefert alle Mitglieder mit der in MitgliederService::SEITEN_GROESSE,
     * definierten Pagination Konstante.
     *
     * @return Illuminate\Database\Eloquent\Collection Eine Collection von Mitgliedern.
     */
    public function holeAlle() 
    {
        return Mitglied::paginate(MitgliederService::SEITEN_GROESSE);
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
        return Mitglied::whereNotIn('id', array($id))->take($limit)->get();
    }

    /**
     * Liefert alle Mitglieder bis auf einen zurück. 
     * Die Mitglieder werden nach ihrem Anfangsbuchstaben im
     * Vornamen gruppiert (Array) zurückgeliefert.
     * Für Pagination können der Start und das Limit 
     * festgelegt werden.
     *
     * @param {integer} id des Users, der ausgeschlossen werden soll
     * @param {integer} start Ab welchem Mitglied.
     * @param {integer} limit Wie viele Mitglieder zurückgegeben werden sollen.
     */
    public function allGroupedExeptForOne($id, $suchbegriff, $start = 0, $limit = FALSE)
    {
        $usersGrouped = array();

        if (isset($suchbegriff))
        {
            $name = explode(' ', trim($suchbegriff));
        
            if (count($name) < 2) 
            {
                // Setze den Nachnamen ebenfalls auf $suchbegriff
                $name[] = $suchbegriff; 
            }
            
            $users = Mitglied
                    ::where('vorname', 'LIKE', '%'.$name[0].'%')
                    ->orWhere('nachname', 'LIKE', '%'.$name[1].'%')
                    ->orWhere('email', 'LIKE', '%'.$name[0].'%')
                    ->orWhere('telefon', 'LIKE', '%'.$name[0].'%')
                    ->orderBy('vorname')
                    ->get();
        }
        else
            $users = Mitglied::all()
                ->sortBy('vorname');
        foreach ($users as $user)
        {
            $firstLetter = strtoupper(substr($user->vorname, 0, 1));
            if (!isset($usersGrouped[$firstLetter]))
                $usersGrouped[$firstLetter] = array();
            array_push($usersGrouped[$firstLetter], $user);
        }

        return $usersGrouped;
        
        /*
        $users = Mitglied::select(DB::raw('*, substring(vorname, 1, 1) as firstletter'))->orderBy('vorname')->take($limit)->get();
        
        foreach ($users as $user)
        {
            if (!isset($usersGrouped[$user->firstletter]))
                $usersGrouped[$user->firstletter] = array();
            array_push($usersGrouped[$user->firstletter], $user);
        }
        return $usersGrouped;
        */
	}

	/**
	 * 
	 * @param array $mitglied
	 * @return {boolean}, falls das Mitglied angelegt worden ist, ansonsten false.
	 */
	public function speichere($mitglied)
	{
		$mitglied['passwort'] = Hash::make($mitglied['passwort']);
        $mitglied->save();
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
                ->paginate(MitgliederService::SEITEN_GROESSE);
	}

	/**
	 * Liefert ein Mitglied mit einer Id aus der Datenbank.
     * 
	 * @param int $id Die ID des Mitglieds, das geladen werden soll.
     * 
	 * @return Mitglied 
	 */
    public function lade($id)
    {
        return Mitglied::find($id);
    }
	
}
