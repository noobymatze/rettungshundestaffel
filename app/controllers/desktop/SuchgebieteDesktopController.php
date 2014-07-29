<?php

/**
 * Kümmert sich um die Suchgebiete in der desktop variante der 
 * Anwendung.
 */
class SuchgebieteDesktopController extends Controller {

	public function __construct(SuchgebieteService $suchgebieteService)
	{
		$this->suchgebieteService = $suchgebieteService;
	}

	/**
	 * Stellt die Übersicht der Suchgebiete dar.
	 *
	 * @return {View} 
	 */
	public function renderSuchgebiete()
	{
		return View::make('suchgebiete.desktop.uebersicht')
						->with('suchbegriff', null)
						->with('suchgebiete', $this->suchgebieteService->all());
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
	}
}
