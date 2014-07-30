<?php

class Termin extends Eloquent {

	protected $table = 'termin';
	protected $fillable = array('id', 'datum', 'art', 'beschreibung', 'adresse_id', 'suchgebiet_id', 'mitglied_id');

	public function mitglieder()
	{
		return $this->belongsToMany('Mitglied', 'mitglied_hat_termin', 'termin_id', 'mitglied_id')
				->withPivot('status', 'status_geandert_am');
	}

	public function ersteller()
	{
		return $this->hasOne('Mitglied', 'id', 'mitglied_id');
	}

	public function adresse()
	{

		return $this->hasOne('Adresse', 'id', 'adresse_id');
	}

	public function suchgebiet()
	{
		return $this->hasOne('Suchgebiet', 'id', 'suchgebiet_id');
	}

	public function hatMitglied($gesuchtesMitglied)
	{
		return !$this->mitglieder->filter(function($mitglied) use($gesuchtesMitglied)
				{
					return $gesuchtesMitglied->id == $mitglied->id;
				})->isEmpty();
	}

	public function mitgliedStatus($mitglied)
	{
		$result = $this->mitglieder->filter(function($m) use ($mitglied)
				{
					return $m->id == $mitglied->id;
				})->first();
		if($result != null)
		{
			return $result->pivot->status;
		}
		return null;
	}
	
	public function mitgliederZugesagt()
	{
		return $this->mitglieder()->whereStatus('Zugesagt')->get();
	}
	
	public function mitgliederAbgesagt()
	{
		return $this->mitglieder()->whereStatus('Abgesagt')->get();
	}
}
