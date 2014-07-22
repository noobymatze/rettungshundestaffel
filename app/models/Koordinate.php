<?php

class Koordinate extends Eloquent
{
    protected $table = 'koordinate';

    public $timestamps = false;

    protected $fillable = array('laengengrad', 'breitengrad');

    public function suchgebiete()
    {
        return $this->belongsToMany('Suchgebiet');
    }
}
