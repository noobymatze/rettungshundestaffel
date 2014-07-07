<?php

/**
 * Kümmert sich um alle Mitglieder in der desktop variante der 
 * Anwendung.
 */
class MitgliederDesktopController extends Controller {

    public function __construct(MitgliederService $mitgliederService) 
    {
        $this->mitgliederService = $mitgliederService;
    }

    /**
     * Stellt die Heimseite dar.
     *
     * @return {View} 
     */
    public function uebersicht() 
    {
        return View::make('mitglieder.desktop.uebersicht')
            ->with('title', 'Mitglieder')
			->with('suchbegriff', null)
            ->with('mitglieder', $this->mitgliederService->all());
    }
	
	/**
	 * Stellt die Seite für das Anlegen eines Mitglieds dar.
	 * 
	 * @return {View}
	 */
	public function renderErstelleMitglied()
	{
		$mitglied = new Mitglied;
		return View::make('mitglieder.desktop.erstelle')
				->with('mitglied', $mitglied);
	}
	
	/**
	 * Erstellt ein neues Mitglied.
	 * 
	 * @return entweder die selbe Seite mit Fehlermeldungen oder die Mitgliederübersicht
	 */
	public function erstelleMitglied()
	{
		$rules = array(
			'email' => 'required|email|unique:mitglied,email',
			'passwort' => 'required',
			'passwort2' => 'required'
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		if($validator->fails())
		{
			return Redirect::to('mitglieder/anlegen')
					->withErrors($validator)
					->withInput(Input::except('passwort', 'passwort2'));
		}
		
		// Passwörter vergleichen
		if(Input::get('passwort') != Input::get('passwort2'))
		{
			return Redirect::to('mitglieder/anlegen')
					->withErrors(array(
						'passwort' => 'Passwörter stimmen nicht überein',
						'passwort2' => null
					));
		}
		
		// Neues Mitglied erstellen
		$mitglied = array(
			'email' => Input::get('email'),
			'vorname' => Input::get('vorname'),
			'nachname' => Input::get('nachname'),
			'passwort' => Input::get('passwort'),
			'rolle' => Input::get('rolle')
		);
		
		// Falls alles geklappt hat, auf die Mitgliederübersicht umleiten
		if($this->mitgliederService->erstelleMitglied($mitglied))
		{
			return Redirect::to('mitglieder');
		}
	}
	
	/**
	 * Zeigt die Seite eines Mitglieds an.
	 */
	public function renderMitglied() 
	{
		return View::make('home');
	}
	
	/**
	 * Filtert die Uebersicht der Mitglieder nach den eingegebenen 
	 * Kriterien.
	 */
	public function filtereUebersicht()
	{
		return View::make('uebersicht')
			->with('mitglieder', $this->mitgliederService->sucheNach());
	}
}
