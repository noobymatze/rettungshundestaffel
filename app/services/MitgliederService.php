<?php

/**
 * Dieser Service ist für alle Datenbankinteraktionen
 * für die Mitglieder verantwortlich.
 */
class MitgliederService {

    /**
     * Authentifiziert ein Mitglied anhand der E-Mail
     * und des Passworts. Diese müssen gesetzt und 
     * validiert sein.
     *
     * @param {string} email Die E-Mail des Mitglieds.
     * @param {string} passwort Das Passwort des Mtiglieds.
     *
     * @return {boolean} true, wenn Authentifizierung erfolgreich, 
     * ansonsten false.
     */
    public function authenticate($email, $passwort) 
    {
        return Auth::attempt(array(
            'email' => $email, 
            // password, weil Laravel Auth-Treiber password und nicht passwort haben möchte
            'password' => $passwort 
        ), true);
    }

    /**
     * Liefert alle Mitglieder zurück. 
     * Für Pagination können der Start und das Limit 
     * festgelegt werden.
     *
     * @param {integer} start Ab welchem Mitglied.
     * @param {integer} limit Wie viele Mitglieder zurückgegeben werden sollen.
     */
    public function all($start = 0, $limit = FALSE) 
    {
        return Mitglied::all();
    }

}
