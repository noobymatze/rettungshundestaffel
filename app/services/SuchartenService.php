<?php

class SuchartenService {

    /**
     * Gibt alle Sucharten zurück.
     * 
     * @return Collection Eine Liste aller Sucharten.
     */
    public function holeAlle() 
    {
        return Suchart::all();
    }

    /**
     * Läd eine Suchart anhand ihres Namens.
     * 
     * @param string $name Der Name der Suchart.
     * 
     * @return Suchart Die Suchart, die gefunden wurde.
     */
    public function ladeMitName($name) 
    {
        return Suchart::where('name', $name)->firstOrFail();
    }

}