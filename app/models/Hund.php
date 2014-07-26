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
            ->withPivot('geprueft_am', 'geprueft_bis');
    }
	
	public function bild()
	{
		if (isset($this->bild)) 
        {
            return 'data:image;base64,' . base64_encode($this->bild);
        }

        return URL::asset('images/kein_bild_hund.gif');
	}

    public function getSuchartGeprueftBis($suchart_id) 
    {
        $suchart = $this->sucharten
                ->filter(function($suchart) use ($suchart_id) {
                    return $suchart->id == $suchart_id;
                })->first();

        if(isset($suchart) && isset($suchart->pivot->geprueft_bis)) {
            return DateTime::createFromFormat("Y-m-d", $suchart->pivot->geprueft_bis)->format('d.m.Y');
        }

        return null;
    }
}
