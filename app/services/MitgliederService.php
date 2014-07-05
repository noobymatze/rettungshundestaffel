<?php

class MitgliederService {


    public function authenticate($email, $passwort) 
    {
        return Auth::attempt(array('email' => $email, 'password' => $passwort));
    }

    public function all() {
        return Mitglied::all();
    }

    public function byNachname($nachname) {
        return Mitglied::where('nachname', $nachname);
    }
}
