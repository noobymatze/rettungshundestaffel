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
		if(!date_create_from_format('d.m.Y', $datumAb))
		{
			$datumAb = date('Y-m-d');
		} else 
		{
			$datumAb = date_format(date_create_from_format('d.m.Y', $datumAb), 'Y-m-d');
		}
		return Termin::where('datum', '>=', $datumAb . ' 00:00:00')
						->orderBy('datum', 'asc')
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
		$neueAdresse = -1;
		$keineAdresse = 0;
		$array = array($keineAdresse => 'Nicht angegeben', $neueAdresse => 'Neue anlegen...');
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
			$array[$suchgebiet->id] = $suchgebiet->name;
		}
		return $array;
	}

	public function zusagen($mitglied, $termin)
	{
        $this->zusagenOderAbsagen($mitglied, $termin);
	}

	public function absagen($mitglied, $termin)
	{
        $this->zusagenOderAbsagen($mitglied, $termin, false);
	}

    public function zusagenOderAbsagen($mitglied, $termin, $zusage = true) 
    {
        $status = $zusage ? 'Zugesagt' : 'Abgesagt';

        try {
            $mitglied = $termin->mitglieder()
                    ->whereTermin_id($termin->id)
                    ->whereMitglied_id($mitglied->id)
                    ->firstOrFail();

            $mitglied->pivot->status = $status;
            $mitglied->pivot->status_geaendert_am = new DateTime;
            $mitglied->pivot->save();
        } catch (Exception $ex) {
            Log::error($ex->getTrace());
            $termin->mitglieder()->save($mitglied, ['status' => $status, 'status_geaendert_am' => new DateTime]);
        }
    }

	public function deaktivieren($termin)
	{
		$termin->aktiv = false;
		$termin->abgesagt_am = new DateTime;
		$this->speichere($termin);
	}

	public function aktivieren($termin)
	{
		$termin->aktiv = true;
		$termin->abgesagt_am = null;
		$this->speichere($termin);
	}

}
