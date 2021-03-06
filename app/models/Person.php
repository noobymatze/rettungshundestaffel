<?php

class Person extends Eloquent
{

    protected $table = 'person';

    public $timestamps = false;

    public function suchgebiet()
    {
        return $this->belongsTo('Suchgebiet');
    }

    public function adresse() 
    {
        return $this->hasOne('Adresse', 'id', 'adresse_id');
    }

    public function vollerName()
    {
        return $this->vorname . ' ' . $this->nachname;
    }

}
