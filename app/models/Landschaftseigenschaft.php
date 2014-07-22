<?php

class Landschaftseigenschaft
{

    protected $table = 'landschaftseigenschaft';

    public $timestamps = false;

    protected $fillable = array('name');

    public function suchgebiete()
    {
        return $this->belongsToMany('Suchgebiet');
    }

}
