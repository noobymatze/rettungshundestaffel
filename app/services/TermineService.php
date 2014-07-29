<?php

/**
 * Dieser Service ist für die Bearbeitung der Termine zuständig.
 * 
 * @author Eugen Feit, Jannik Hell, Matthias Metzger
 */
class TermineService {

	const SEITEN_GROESSE = 10;

	/**
	 * Holt alle Termine aus der Datenbank ab einem vorgegebenem Datum. Falls kein Datum
	 * angegeben wurde, wird das heutige Datum genommen.
	 * @param type $datumAb
	 * @return type
	 */
	public function holeAlle($datumAb = null)
	{
		if($datumAb == null)
		{
			$datumAb = date('Y-m-d');
		}
		return Termin::where('datum', '>=', $datumAb . ' 00:00:00')
//				->sortBy('datum')
				->paginate(TermineService::SEITEN_GROESSE);
	}
	
	public function speichere($termin)
	{
		$termin->save();
	}

	public function lade($id)
	{
		return Termin::find($id);
	}

	public function loesche($id)
	{
		
	}

	public function holeAlleAdressenAlsArray()
	{
		$neueAdresseWert = -1;
		$keineAdresse = 0;
		$array = array($keineAdresse => 'Nicht angegeben', $neueAdresseWert => 'Neue anlegen...');
		$adressen = Adresse::all();
		foreach ($adressen as $adresse)
		{
			$array[$adresse->id] = $adresse->adresseKurz();
		}
		return $array;
	}
	
	public function holeAlleSuchgebieteAlsArray()
	{
		$keineAdresse = 0;
		$array = array($keineAdresse => 'Nicht angegeben');
		$suchgebiete = Suchgebiet::all();
		foreach ($suchgebiete as $suchgebiet)
		{
		$array[$suchgebiet->id] =  $suchgebiet->name;
		}
		return $array;
	}
}
