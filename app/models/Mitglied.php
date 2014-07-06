<?php

use Illuminate\Auth\UserInterface;

class Mitglied extends Eloquent implements UserInterface 
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mitglied';

    public $timestamps = false;

    protected $fillable = array('vorname', 'nachname', 'email', 'passwort', 'telefon', 'rolle');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    /**
     * Liefert den vollen Namen dieses Mitglieds zurück.
     *
     * @return {string} 
     */
    public function vollerName() 
    {
        return $this->vorname.' '.$this->nachname;
    }

    public function hunde() 
    {
        return $this->hasMany('Hund', 'mitglied_id', 'id');
    }

    public function termine()
    {
        return $this
            ->belongsToMany(
                'Termin', 'mitglied_hat_termin', 'mitglied_id', 'termin_id')
            ->withPivot('status', 'status_geaendert_am');
    }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
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

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
