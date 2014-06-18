<?php

class Termin
{

    protected $table = 'termin';

    public function mitglieder()
    {
        return $this->belongsToMany('Mitglied');
    }
}
