<?php

class Suchgebiet extends Eloquent
{

    protected $table = 'suchgebiet';

    protected $fillable = array('name', 'beschreibung', 'treffpunkt', 'created_at', 'updated_at');

    public function treffpunkt()
    {
        return $this->hasOne('Koordinate', 'suchgebiet_id');
    }

    public function koordinaten()
    {
        return $this->belongsToMany('Koordinate', 'suchgebiet_hat_koordinaten', 'suchgebiet_id', 'koordinate_id');
    }

    public function personen()
    {
        return $this->hasMany('Person', 'suchgebiet_id');
    }

    public function landschaftseigenschaften()
    {
        return $this->belongsToMany(
            'Landschaftseigenschaft', 
            'suchgebiet_hat_landschaftseigenschaft',
            'suchgebiet_id',
            'Landschaftseigenschaft_id');
    }

    public function getAnsprechpartner()
    {
        return null;
    }
}
