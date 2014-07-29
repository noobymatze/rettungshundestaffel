<?php

class Termin extends Eloquent
{

    protected $table = 'termin';
	protected $fillable = array('id', 'datum', 'art', 'beschreibung', 'adresse_id', 'suchgebiet_id', 'mitglied_id');

    public function mitglieder()
    {
        return $this->belongsToMany('Mitglied');
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
}
