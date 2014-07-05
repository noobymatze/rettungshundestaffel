<?php

class MitgliedSeeder extends Seeder {

    public function run() 
    {
        DB::table('mitglied')->delete();

        Mitglied::create(array(
            'vorname' => 'Matthias',
            'nachname' => 'Metzger',
            'rolle' => 'Staffelleitung',
            'email' => 'noobymatze@yahoo.de',
            'passwort' => Hash::make('peter09')
        ));

    }
}
