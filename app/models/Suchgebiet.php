<?php

class Suchgebiet extends Eloquent
{

    protected $table = 'suchgebiet';

    protected $fillable = array('name', 'beschreibung', 'treffpunkt', 'created_at', 'updated_at');

    // funktion darf nicht heißen, wie Tabellenspalte, deswegen "adresse"
    public function adresse()
    {
        return $this->belongsTo('Adresse', 'treffpunkt', 'id');
    }

    // funktion darf nicht heißen, wie Tabellenspalte, deswegen "ansprechperson"
    public function ansprechperson()
    {
        return $this->belongsTo('Mitglied', 'ansprechpartner', 'id');
    }

    /*
    public function koordinaten()
    {
        return $this->belongsToMany('Koordinate', 'suchgebiet_hat_koordinaten', 'suchgebiet_id', 'koordinate_id');
    }
    */

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
            'Eigenschaft', 
            'suchgebiet_eigenschaft',
            'suchgebiet_id',
            'eigenschaft_id');
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
