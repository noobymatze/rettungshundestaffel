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
		if ($this->bild) 
        {
            return 'data:image;base64,' . base64_encode($this->bild);
        }

        return URL::asset('images/kein_bild_hund.gif');
	}

    public function getSuchartGeprueftBis($suchart_id) 
    {
        $sucharten = $this->sucharten
                ->filter(function($suchart) use ($suchart_id) {
                    return $suchart->id == $suchart_id;
                });
        if($sucharten->count() > 0) {
            return DateTime::createFromFormat("Y-m-d", $sucharten[0]->pivot->geprueft_bis)->format('d.m.Y');
        }

        return null;
    }
}
