<?php

class Suchgebiet extends Eloquent
{

    protected $table = 'suchgebiet';

    protected $fillable = array('name', 'beschreibung', 'treffpunkt', 'created_at', 'updated_at');

    public function treffpunkt()
    {
        return $this->belongsTo('Adresse', 'treffpunkt');
    }

    public function flaechen()
    {
        return $this->hasMany('Flaeche', 'suchgebiet_id');
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
            'landschaftseigenschaft_id');
    }

    public function landschaftseigenschaftenAsString($delimiter = ',') 
    {
        return join($delimiter, $this->landschaftseigenschaften->map(function($eigenschaft) {
            return $eigenschaft->name;
        })->toArray());
    }

    public function getAnsprechpartner() 
    {
        if(!isset($this->ansprechpartner)) {
            $this->ansprechpartner = $this->personen()->whereTyp('Ansprechpartner')->first();
        }

        return $this->ansprechpartner;
    }

    public function hatAnsprechpartner() 
    {
        return null !== $this->getAnsprechpartner();
    }

    public function getFlaechenAlsArray() 
    {
        return $this->flaechen->map(function($flaeche) {
            $flaeche->koordinaten = $flaeche->getPolygonAlsArray();
            return $flaeche;
        });
    }
}
