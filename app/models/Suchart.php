<?php

class Suchart extends Eloquent
{
    protected $table = 'suchart';

    public $timestamps = false;

    protected $fillable = array('name');

    /**
     * N:M Assoziation für die Hunde dieser Suchart.
     */
    public function hunde()
    {
        return $this->belongsToMany('Hund');
    }
}
