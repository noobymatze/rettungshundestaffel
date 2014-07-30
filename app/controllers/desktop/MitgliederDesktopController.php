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
        $suchbegriff = Input::get('suchbegriff');

		return View::make('mitglieder.desktop.uebersicht')
						->with('suchbegriff', null)
						->with('mitglieder', $this->mitgliederService->sucheNach($suchbegriff));
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
	public function erstelle()
	{
		$rules = array(
			'email' => 'required|email|unique:mitglied,email',
			'passwort' => 'required',
			'passwort2' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::to('mitglieder/anlegen')
							->withErrors($validator)
							->withInput(Input::except('passwort', 'passwort2'));
		}

		// Passwörter vergleichen
		if (Input::get('passwort') != Input::get('passwort2'))
		{
			return Redirect::to('mitglieder/anlegen')
							->withErrors(array(
								'passwort' => 'Passwörter stimmen nicht überein',
								'passwort2' => null))
							->withInput(Input::except('passwort', 'passwort2'));
		}

		// neues Mitglied erstellen
		$mitglied = new Mitglied;
		$mitglied->email = Input::get('email');
		$mitglied->vorname = Input::get('vorname');
		$mitglied->nachname = Input::get('nachname');
		$mitglied->passwort = Input::get('passwort');
		$mitglied->rolle = Input::get('rolle');


		// Falls alles geklappt hat, auf die Mitgliederübersicht umleiten
		$this->mitgliederService->speichere($mitglied);
		return Redirect::to('mitglieder');
	}

	public function aktualisiere($id)
	{
        $exclusions = ['passwort', 'passwort2', 'profilbild'];

		// Überprüfen, ob der Benutzer sein eigenes Profil ändert, oder es der Admin tut
		if (Auth::user()->id != $id && Auth::user()->rolle != "Staffelleitung")
		{
			// Fehlermeldung, keine Rechte
			return Redirect::action('MitgliederDesktopController@renderMitglied', array('id' => $id));
		}
		
		$mitglied = $this->mitgliederService->lade(intval($id));

		// die Rolle darf nur die Staffelleitung ändern
		if (Input::has('rolle') && $mitglied->rolle != Input::get('rolle'))
		{
			if (Auth::user()->rolle != "Staffelleitung")
			{
				// Fehlermeldung ausgeben, keine Rechte
                return Redirect::action('MitgliederDesktopController@renderMitglied', array('id' => $id));
			}
		}

		// Wurde die E-Mail geändert?
		if ($mitglied->email != Input::get('email'))
		{
			$rules = array(
				'email' => 'required|email|unique:mitglied,email'
			);

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::action('MitgliederDesktopController@renderMitgliedBearbeiten', array('id' => $id))
								->withErrors($validator)
								->withInput(Input::except($exclusions));
			}
		}
		
		// Wurde ein Bild ausgewählt?
		if(Input::hasFile('profilbild'))
		{
			$rules = array(
				'profilbild' => 'mimes:jpg,jpeg,png,gif'
			);

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails())
			{
				return Redirect::action('MitgliederDesktopController@renderMitgliedBearbeiten', array('id' => $id))
								->withErrors($validator)
								->withInput(Input::except($exclusions));
			}
			$mitglied->profilbild = File::get(Input::file('profilbild')->getRealPath());
		}

		// Hat der Benutzer sein Passwort geändert (also irgendwas ins Textfeld eingegeben)?
		if (Input::get('passwort') != '')
		{
			// Passwörter vergleichen
			if (Input::get('passwort') != Input::get('passwort2'))
			{
				return Redirect::action('MitgliederDesktopController@renderMitgliedBearbeiten', array('id' => $id))
								->withErrors(array(
									'passwort' => 'Passwörter stimmen nicht überein',
									'passwort2' => null))
								->withInput(Input::except($exclusions));
			}
			$mitglied->passwort = Input::get('passwort');
		}

		// Ansonsten die Daten einfach übernehmen
		$mitglied->email = Input::get('email');
		$mitglied->vorname = Input::get('vorname');
		$mitglied->nachname = Input::get('nachname');
		$mitglied->telefon = Input::get('telefon');
		$mitglied->mobil = Input::get('mobil');

        if(Input::has('rolle')) {
            $mitglied->rolle = Input::get('rolle');
        }

		$this->mitgliederService->speichere($mitglied);

        Log::info("Hier bin ich.");
		return View::make('mitglieder.desktop.details')
						->with('mitglied', $mitglied);
	}

	/**
	 * Zeigt die Seite eines Mitglieds an.
	 */
	public function renderMitglied($id)
	{
		$mitglied = $this->mitgliederService->lade($id);
		return View::make('mitglieder.desktop.details')
						->with('mitglied', $mitglied);
	}

	/**
	 * Stellt die Seite für das Bearbeiten eines Mitglieds das.
	 * @param type $id
	 */
	public function renderMitgliedBearbeiten($id)
	{
		$mitglied = $this->mitgliederService->lade($id);
		return View::make('mitglieder.desktop.bearbeiten')
						->with('mitglied', $mitglied);
	}

    /**
     * Löscht das Mitglied aus der Datenbank.
     * 
     * @param string $id 
     * @return Mitgliederuebersicht.
     */
    public function loesche($id) 
    {
        $mitglied_id = intval($id);
        $this->mitgliederService->loesche($id);

        return Redirect::action('MitgliederDesktopController@uebersicht');
    }

}
