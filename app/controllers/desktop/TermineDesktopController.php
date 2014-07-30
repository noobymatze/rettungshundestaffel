<?php

class TermineDesktopController extends Controller {

	function __construct(TermineService $termineService)
	{
		$this->termineService = $termineService;
	}

	public function uebersicht()
	{
		$datum = Input::get('datum');
//		if($datum == null)
//		{
//			$datum = date('Y-m-d');
//		} else
//		{
//			$datum = Input::get('datum');
//		}
		$termine = $this->termineService->holeAlle($datum);
		return View::make('termine.desktop.uebersicht')
						->with('termine', $termine);
	}

	public function speichere()
	{
		$datumFormat = 'd.m.Y - H:i';
		$regeln = [];
		$regeln['datum'] = 'required|date_format:' . $datumFormat;
		$regeln['art'] = 'required';

		if (Input::get('id') != null)
		{
			$termin = $this->termineService->lade(Input::get('id'));
		} else
		{
			$termin = new Termin;
		}
		$termin->mitglied_id = Auth::user()->id;
		$termin->fill(Input::all());
		$termin->datum = DateTime::createFromFormat($datumFormat, Input::get('datum'));
		$termin->aktiv = true;
		$termin->abgesagt_am = null;
		if (Input::get('suchgebiet_id') == 0)
		{
			$termin->suchgebiet_id = null;
		}

		if (Input::get('adresse_id') == 0)
		{
			$termin->adresse_id = null;
		} else if (Input::get('adresse_id') == -1)
		{
			$adresse = new Adresse;
			$regeln['ort'] = 'required';
			$regeln['hausnummer'] = 'integer';
			$adresse->ort = Input::get('ort');
			if (Input::get('strasse') != '')
			{
				$adresse->strasse = Input::get('strasse');
			}
			if (Input::get('hausnummer') != '')
			{
				$adresse->hausnummer = Input::get('hausnummer');
			}
			if (Input::get('postleitzahl') != '')
			{
				$adresse->postleitzahl = Input::get('postleitzahl');
			}
			if (Input::get('zusatz') != '')
			{
				$adresse->zusatz = Input::get('zusatz');
			}
		}

		$validator = Validator::make(Input::all(), $regeln);

		if ($validator->fails())
		{
			return Redirect::back()
							->withInput()
							->withErrors($validator);
		}

		if (Input::get('adresse_id') == -1)
		{
			$adresse->save();
			$termin->adresse_id = $adresse->id;
		}

		$this->termineService->speichere($termin);
		return Redirect::action('TermineDesktopController@uebersicht');
	}

	public function renderErstelleTermin()
	{
		$termin = new Termin;
		$now = new DateTime;
		$now->setTime(8, 0, 0);
		$termin->datum = $now->modify('+7 day');
		$termin->art = 'Allgemein';
		$termin->aktiv = true;

//		$this->termineService->speichere($termin);
		return View::make('termine.desktop.erstelle')
						->with('termin', $termin)
						->with('adressenArray', $this->termineService->holeAlleAdressenAlsArray())
						->with('suchgebieteArray', $this->termineService->holeAlleSuchgebieteAlsArray());
	}

	public function renderBearbeiteTermin($terminId)
	{
		$termin = $this->termineService->lade($terminId);
		$termin->datum = date_create_from_format('Y-m-d H:i:s', $termin->datum);
		return View::make('termine.desktop.erstelle')
						->with('termin', $termin)
						->with('adressenArray', $this->termineService->holeAlleAdressenAlsArray())
						->with('suchgebieteArray', $this->termineService->holeAlleSuchgebieteAlsArray());
	}
	
	public function renderDetailansicht($id)
	{
		$termin = $this->termineService->lade($id);
		return View::make('termine.desktop.details')
						->with('termin', $termin);
	}
	
	public function zusage($id)
	{
		$this->termineService->zusagen(Auth::user(), $this->termineService->lade($id));
		return Redirect::back();
	}
	
	public function absage($id)
	{
		$this->termineService->absagen(Auth::user(), $this->termineService->lade($id));
		return Redirect::back();
	}
	
	public function deaktiviereTermin($id)
	{
		$termin = $this->termineService->lade($id);
		$this->termineService->deaktivieren($termin);
		return Redirect::back();
	}
	
	public function aktiviereTermin($id)
	{
		$termin = $this->termineService->lade($id);
		$this->termineService->aktivieren($termin);
		return Redirect::back();
	}

}
