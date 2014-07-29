<?php

class Adresse extends Eloquent
{
    protected $table = 'adresse';

    public $timestamps = false;

    protected $fillable = array('strasse', 'hausnummer', 'zusatz', 'ort', 'postleitzahl');
	
	public function adresseKurz() 
    {
        return $this->ort.' '.$this->strasse.' '.$this->hausnummer.' '.$this->zusatz;
    }

}
