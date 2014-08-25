<?php

/**
 * Kümmert sich um die Suchgebiete in der desktop variante der 
 * Anwendung.
 */
class SuchgebieteDesktopController extends Controller {

	public function __construct(SuchgebieteService $suchgebieteService, MitgliederService $mitgliederService)
	{
		$this->suchgebieteService = $suchgebieteService;
		$this->mitgliederService = $mitgliederService;
	}

	/**
	 * Stellt die Übersicht der Suchgebiete dar.
	 *
	 * @return {View} 
	 */
	public function renderSuchgebiete()
	{
		$suchgebiet = new Suchgebiet;

		return View::make('suchgebiete.desktop.uebersicht')
						->with('suchbegriff', null)
						->with('suchgebiet', $suchgebiet)
						->with('suchgebiete', Suchgebiet::all());
	}

	/**
	 * Stellt die Steite zum Anlegen eines Suchgebiets dar.
	 *
	 * @return {View} 
	 */
	public function renderAddSuchgebiet()
	{
		$suchgebiet = new Suchgebiet;

		return View::make('suchgebiete.desktop.add-suchgebiet')
			->with('suchgebiet', $suchgebiet);
	}

	/**
	 * Fügt ein neues Suchgebiet hinzu
	 *
	 * @return {View} 
	 */
	public function add()
	{
		$rules = array(
			'bezeichnung' => 'required|min:3|max:20|unique:suchgebiet,name',
		);

		$messages = array(
		    'bezeichnung.required' => 'Das Suchgebiet muss eine Bezeichnung haben.',
		    'bezeichnung.max' => 'Das Suchgebiet darf nur maximal aus 20 Zeichen bestehen.',
		    'bezeichnung.min' => 'Das Suchgebiet muss mindestens aus 3 Zeichen bestehen.',
		    'bezeichnung.unique' => 'Ein Suchgebiet mit diesem Namen gibt es schon.'
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return Redirect::back()
				->withErrors($validator)
				->withInput(Input::all());
		}
		else
		{
			// neues Suchgebiet erstellen
			$suchgebiet = new Suchgebiet;
			$suchgebiet->name = Input::get('bezeichnung');

			$this->suchgebieteService->speichere($suchgebiet);

			// Falls alles geklappt hat, auf die Suchgebieteübersicht umleiten
			return Redirect::to('suchgebiete' . '/' . $suchgebiet->id . '/' . Str::slug($suchgebiet->name, '_'));
		}
	}

	/**
	 * Zeigt ein Suchgebiet mit Infos an
	 *
	 * @return {View} 
	 */
	public function renderSuchgebiet($id = null)
	{
		//Log::debug(str_replace('_', ' ', $name));
		$suchgebiet = $this->suchgebieteService->lade($id);

		$flaechen = $this->suchgebieteService->ladeFlaechenAsGeoJson($suchgebiet);
		$boundingBox = $this->suchgebieteService->getBoundingBox($suchgebiet);
		$mitglieder = Mitglied::all();

		return View::make('suchgebiete.desktop.suchgebiet')
			->with('suchgebiet', $suchgebiet)
			->with('flaechen', $flaechen)
			->with('boundingBox', json_encode($boundingBox))
			->with('mitglieder', $mitglieder);
	}

	/**
	 * Zeigt ein Suchgebiet mit der Karte an
	 *
	 * @return {View} 
	 */
	public function renderKarte($id = null)
	{
		//Log::debug(str_replace('_', ' ', $name));
		$suchgebiet = $this->suchgebieteService->lade($id);

		$flaechen = $this->suchgebieteService->ladeFlaechenAsGeoJson($suchgebiet);
		$boundingBox = $this->suchgebieteService->getBoundingBox($suchgebiet);
		$mitglieder = Mitglied::all();

		return View::make('suchgebiete.desktop.karte')
			->with('suchgebiet', $suchgebiet)
			->with('flaechen', $flaechen)
			->with('boundingBox', json_encode($boundingBox));
	}

    /**
     * Zeigt die Personen des Suchgebietes an.
     * 
     * @return View
     */
    public function renderPersonen($id) 
    {
        $suchgebiet = $this->suchgebieteService->lade($id);
		$flaechen = $this->suchgebieteService->ladeFlaechenAsGeoJson($suchgebiet);
		$boundingBox = $this->suchgebieteService->getBoundingBox($suchgebiet);

        return View::make('suchgebiete.desktop.personen')
                ->with('boundingBox', json_encode($boundingBox))
                ->withFlaechen($flaechen)
                ->withSuchgebiet($suchgebiet);

    }

    public function editPerson() 
    {

        return "haha";

    }

	public function editAdresse($id = null)
	{
		$rules = array(
			'strasse' => 'min:3|max:30',
			'hausnummer' => 'digits_between:1,10|numeric',
			'zusatz' => 'min:1|max:30',
			'ort' => 'min:2|max:30',
			'plz' => 'digits_between:4,6|numeric',
		);

		$messages = array(
		    'strasse' => 'Die Straße muss zwischen 3 und 30 Zeichen haben.',
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'error' => $validator->messages()->first(),
				'data' => Input::all(),
			));
		}

		$suchgebiet = $this->suchgebieteService->lade($id);

		$adresse = ($suchgebiet->adresse != null) ? $suchgebiet->adresse : new Adresse;

		$adresse->strasse = Input::get('strasse');
		$adresse->hausnummer = Input::get('hausnummer');
		$adresse->zusatz = Input::get('zusatz');
		$adresse->postleitzahl = Input::get('plz');
		$adresse->ort = Input::get('ort');
		$adresse->save();

		$suchgebiet->treffpunkt = $adresse->id;

		$this->suchgebieteService->speichere($suchgebiet);

		return Response::json(array('success' => true, 'data' => Input::all()));
	}

	public function editEigenschaften($id = null)
	{
		$rules = array(
			'eigenschaften' => '',
		);

		$messages = array(
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'error' => $validator->messages()->first(),
				'data' => Input::all(),
			));
		}

		$suchgebiet = $this->suchgebieteService->lade($id);
		$this->suchgebieteService->speichereEigenschaften($suchgebiet, explode(",", Input::get('eigenschaften')));

		return Response::json(array('success' => true, 'data' => Input::all()));
	}

	public function editAnsprechpartner($id = null)
	{
		$rules = array(
			'ansprechpartner' => 'numeric',
		);

		$messages = array(
		    'ansprechpartner' => 'Den Ansprechpartner gibt es nicht.',
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'error' => $validator->messages()->first(),
				'data' => Input::all(),
			));
		}

		$suchgebiet = $this->suchgebieteService->lade($id);

		$suchgebiet->ansprechpartner = Input::get('ansprechpartner');

		$this->suchgebieteService->speichere($suchgebiet);

		return Response::json(array('success' => true, 'data' => Input::all()));
	}

	public function editBeschreibung($id = null)
	{
		$rules = array(
			'beschreibung' => '',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'error' => $validator->messages()->first(),
				'data' => Input::all(),
			));
		}

		$suchgebiet = $this->suchgebieteService->lade($id);
		$suchgebiet->beschreibung = Input::get('beschreibung');

		$this->suchgebieteService->speichere($suchgebiet);

		return Response::json(array('success' => true, 'data' => Input::all()));
	}

	public function editKarte($id = null)
	{
		Validator::extend('json', function($attribute, $value, $parameters)
		{

			$decoded = json_decode($value);

			if ($decoded === null)
				return false;
			else
				return true;
		});

		Validator::extend('geojsonarray', function($attribute, $value, $parameters = array())
		{
			switch ($parameters[0]) {
				case 'polygon':
					$geometryType = $parameters[0];
					break;
				default:
					$geometryType = null;
					break;
			}

			$geometries = json_decode($value);

			if ($geometries === null || !is_array($geometries))
				return false;

			foreach ($geometries as $geometry)
			{
				if (!isset($geometry->geometry))
					return false;
				if (isset($geometryType))
					if (!isset($geometry->geometry->type) || $geometry->geometry->type !== $geometryType)
						return false;
			}

			return true;
		});

		$rules = array(
			'flaeche' => 'required|sometimes|json',
		);

		$messages = array(
		    'flaeche.json' => 'Die übertragenen Flächendaten sind fehlerhaft.',
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'error' => $validator->messages()->first(),
				'data' => Input::all(),
			));
		}


		$geoJsonFlaechen = json_decode(Input::get('flaeche'));

		if ($geoJsonFlaechen === null)
		{
			return Response::json(array(
				'success' => false,
				'error' => 'Fehler bei Auswerten der Flächen-Koordinaten.',
				'data' => Input::all(),
			));
		}

		$flaechen = array();

		foreach ($geoJsonFlaechen as $geoJsonFlaeche)
		{
			$polygon = geoPHP::load(json_encode($geoJsonFlaeche), 'json');
			$polygonWkt = $polygon->out('wkt');
			//Log::debug('WKT vom Polygon: ');
			//Log::debug($polygonWkt);
			$flaeche = new Flaeche;
			$flaeche->polygon = $polygonWkt;

			array_push($flaechen, $flaeche);
		}

		$suchgebiet = $this->suchgebieteService->lade($id);
		Flaeche::where('suchgebiet_id', '=', $suchgebiet->id)->delete();

		$this->suchgebieteService->speichereZugehoerigeFlaechen($suchgebiet, $flaechen);

		// Falls alles geklappt hat, auf die Suchgebieteübersicht umleiten
		//return Redirect::to('suchgebiete');

		/*$suchgebiet = $this->suchgebieteService->lade($id);

		$adresse = ($suchgebiet->adresse != null) ? $suchgebiet->adresse : new Adresse;

		$adresse->strasse = Input::get('strasse');
		$adresse->hausnummer = Input::get('hausnummer');
		$adresse->zusatz = Input::get('zusatz');
		$adresse->postleitzahl = Input::get('plz');
		$adresse->ort = Input::get('ort');
		$adresse->save();

		$suchgebiet->treffpunkt = $adresse->id;

		$this->suchgebieteService->speichere($suchgebiet);*/

		return Response::json(array('success' => true, 'data' => Input::all()));
	}


	/**
	 * Fügt ein neues Suchgebiet hinzu
	 *
	 * @return {View} 
	 */
	/*public function add()
	{
		Validator::extend('json', function($attribute, $value, $parameters)
		{

			$decoded = json_decode($value);

			if ($decoded === null)
				return false;
			else
				return true;
		});

		Validator::extend('geojsonarray', function($attribute, $value, $parameters = array())
		{
			switch ($parameters[0]) {
				case 'polygon':
					$geometryType = $parameters[0];
					break;
				default:
					$geometryType = null;
					break;
			}

			$geometries = json_decode($value);

			if ($geometries === null || !is_array($geometries))
				return false;

			foreach ($geometries as $geometry)
			{
				if (!isset($geometry->geometry))
					return false;
				if (isset($geometryType))
					if (!isset($geometry->geometry->type) || $geometry->geometry->type !== $geometryType)
						return false;
			}

			return true;
		});

		$rules = array(
			'bezeichnung' => 'required|min:1|max:20|unique:suchgebiet,name',
			'flaeche' => 'sometimes|json',
			'beschreibung' => 'sometimes',
		);

		$messages = array(
		    'bezeichnung.required' => 'Das Suchgebiet muss eine Bezeichnung haben.',
		    'flaeche.geoJsonArray' => 'Die übertragenen Flächendaten sind fehlerhaft.',
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return Redirect::back()
							->withErrors($validator)
							->withInput(Input::all());
		}

		if (Input::has('flaeche'))
		{
			$geoJsonFlaechen = json_decode(Input::get('flaeche'));

			if ($geoJsonFlaechen === null)
			{
				return Redirect::back()
							->withErrors(array(
								'flaeche' => 'Fehler bei Auswerten der Flächen-Koordinaten.'))
							->withInput(Input::except('flaeche'));
			}

			$flaechen = array();

			foreach ($geoJsonFlaechen as $geoJsonFlaeche)
			{
				$polygon = geoPHP::load(json_encode($geoJsonFlaeche), 'json');
				$polygonWkt = $polygon->out('wkt');
				Log::debug('WKT vom Polygon: ');
				Log::debug($polygonWkt);
				$flaeche = new Flaeche;
				$flaeche->polygon = $polygonWkt;

				array_push($flaechen, $flaeche);
			}
		}

		// neues Suchgebiet erstellen
		$suchgebiet = new Suchgebiet;
		$suchgebiet->name = Input::get('bezeichnung');
		$suchgebiet->beschreibung = Input::get('beschreibung');

		$this->suchgebieteService->speichere($suchgebiet);
		$this->suchgebieteService->speichereZugehoerigeFlaechen($suchgebiet, $flaechen);

		// Falls alles geklappt hat, auf die Suchgebieteübersicht umleiten
		return Redirect::to('suchgebiete');
	}*/
}
