<?php

class Person extends Eloquent
{

    protected $table = 'person';

    public $timestamps = false;

    public function suchgebiet()
    {
        return $this->belongsTo('Suchgebiet');
    }
}
