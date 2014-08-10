<?php

class Eigenschaft extends Eloquent
{

    protected $table = 'eigenschaft';

    public $timestamps = false;

    protected $fillable = array('name');

    public function suchgebiete()
    {
        return $this->belongsToMany(
            'Suchgebiet', 
            'suchgebiet_eigenschaft',
            'eigenschaft_id',
            'suchgebiet_id');
        //return $this->belongsToMany('Suchgebiet');
    }
}
