<?php

class Hund extends Eloquent 
{
    protected $table = 'hund';

    protected $fillable = array('name', 'rasse', 'alter');

    public $timestamps = false;

    /**
     * Stellt die Beziehung zu der Mitgliedertabelle dar.
     *
     */
    public function mitglied() 
    {
        return $this->belongsTo('Mitglied');
    }

    public function sucharten() 
    {
        return $this
            ->belongsToMany(
                'Suchart', 'hund_hat_suchart', 'hund_id', 'suchart_id')
            ->withPivot('geprueft', 'geprueft_am', 'geprueft_bis');
    }

}
