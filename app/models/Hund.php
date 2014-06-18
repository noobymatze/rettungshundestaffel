<?php


use Illuminate\Auth\UserInterface;

class Hund extends Eloquent 
{
    protected $table = 'hund';

    protected $fillable = array('name', 'rasse', 'alter');

    /**
     * Stellt die Beziehung zu der Mitgliedertabelle dar.
     *
     */
    public function mitglied() 
    {
        return $this->belongsTo('Mitglied');
    }
}
