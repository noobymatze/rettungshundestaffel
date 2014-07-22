<?php

/**
 * Dieser Service ist für die Bearbeitung der Hunde zuständig.
 * 
 * @author Eugen Feit, Jannik Hell, Matthias Metzger
 */
class HundeService {

    /**
     * Speichert einen Hund oder aktualisiert diesen, wenn er eine 
     * id aufweist.
     * 
     * @param type $hund
     */
    public function speichere($hund) 
    {
        $hund->save();
    }

    /**
     * Holt einen einzelnen Hund anhand seiner ID aus der Datenbank.
     * 
     * @param int $id Die einzigartige ID des Hundes.
     * @return Hund Der aus der Datenbank oder null, wenn keiner gefunden wurde.
     */
    public function lade($id)
    {
        return Hund::find($id);
    }

    /**
     * Loesche den Hund mit der ID.
     * 
     * @param int $id Die ID des Hundes, der gelöscht werden soll.
     */
    public function loesche($id) 
    {
        $hund = $this->lade($id);
        foreach($hund->sucharten as $suchart) {
            $hund->sucharten()->detach($suchart);
        }

        Hund::destroy($id);
    }
}