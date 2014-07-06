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
	 * 
	 * @return type
	 */
	public function erstelleMitglied()
	{
		$rules = array(
			'email' => 'required|email',
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
		
		if(Input::get('passwort') != Input::get('passwort2'))
		{
			return Redirect::to('mitglieder/anlegen')
					->withErrors(array(
						'passwort' => 'Passwörter stimmen nicht überein',
						'passwort2' => null
					));
		}
		
		$mitglied = array(
			'email' => Input::get('email'),
			'passwort' => Input::get('passwort')
		);
		
		
		
		if($this->mitgliederService->erstelleMitglied($mitglied))
		{
			return uebersicht();
		}
	}
}
