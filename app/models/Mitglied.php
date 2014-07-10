<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;

class Mitglied extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait;

	protected $table = 'mitglied';

    public $timestamps = false;

    protected $fillable = array('vorname', 'nachname', 'email', 'passwort', 'telefon', 'rolle');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    /**
     * Liefert den vollen Namen dieses Mitglieds zurück.
     *
     * @return {string} 
     */
    public function vollerName() 
    {
        return $this->vorname.' '.$this->nachname;
    }

    public function profilbild() 
    {
        if ($this->profilbild) 
        {
            return 'data:image;base64,' . base64_encode($this->profilbild);
        }
        return URL::asset('images/kein_bild.png');
    }
	
	public function profilbildextension()
	{
		
	}


    /**
     * Liefert die Hunde des derzeitigen Mitglieds zurück.
     *
     * @return {array} Hunde des Mitglieds.
     */
    public function hunde() 
    {
        return $this->hasMany('Hund', 'mitglied_id', 'id');
    }

    /**
     * Liefert die Termine dieses Mitglieds zurück.
     *
     * @return {array} Termine des Mitglieds.
     */
    public function termine()
    {
        return $this
            ->belongsToMany(
                'Termin', 'mitglied_hat_termin', 'mitglied_id', 'termin_id')
            ->withPivot('status', 'status_geaendert_am');
    }

    /**
     * Liefert eine Liste von Suchtypen, in denen das
     * Mitglied Hunde hat, die dort eine Prüfung abgelegt
     * haben, die gültig ist (nicht abgelaufen).
     *
     * @return {Collection} 
     */
    public function holeGueltigePruefungen()
    {
        $retSuchtypen = array();
        $suchtypen = Mitglied::join('hund', 'mitglied.id', '=', 'hund.mitglied_id')
            ->join('hund_hat_suchart', 'hund.id', '=', 'hund_hat_suchart.hund_id')
            ->join('suchart', 'hund_hat_suchart.suchart_id', '=', 'suchart.id')
            ->select('suchart.suchtyp')
            ->distinct()
            ->where('mitglied.id', '=', $this->id)->get();
        foreach ($suchtypen as $suchtyp)
        {
            $retSuchtypen[$suchtyp->suchtyp] = 1;
        }
        return $retSuchtypen;
            //return '<pre>'.var_dump($this->id).'</pre>';
            //->get();
        //return $this->hasMany('Hund', 'mitglied_id', 'id')->belongsToMany('Suchart', 'hund_hat_suchart', 'hund_id', 'suchart_id');
        //return Mitglied::select(DB::raw(' DISTINCT suchart.suchtyp FROM staffel.mitglied inner join staffel.hund on mitglied_id = mitglied.id inner join staffel.hund_hat_suchart on hund.id = hund_hat_suchart.hund_id inner join staffel.suchart on hund_hat_suchart.suchart_id = suchart.id where geprueft_bis > now() && mitglied.id = ' . $this->id . ';'));
    }

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->passwort;
	}
}
