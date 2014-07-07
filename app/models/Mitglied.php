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
            return $this->profilbild;
        }

        return URL::asset('images/Fachhochschule_Flensburg.svg');
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
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->passwort;
	}

}
