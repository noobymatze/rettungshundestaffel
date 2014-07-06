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

        Mitglied::create(array(
            'vorname' => 'Eugen',
            'nachname' => 'Feit',
            'rolle' => 'Staffelleitung',
            'email' => 'eugen.feit@tester.com',
            'passwort' => Hash::make('peter09')
        ));

        Mitglied::create(array(
            'vorname' => 'Jannik',
            'nachname' => 'Hell',
            'rolle' => 'Staffelleitung',
            'email' => 'jannik.hell@tester.com',
            'passwort' => Hash::make('peter09')
        ));

        Mitglied::create(array(
            'vorname' => 'Barbara',
            'nachname' => 'Müller',
            'rolle' => 'Staffelleitung',
            'email' => 'b.mueller@tesre.com',
            'passwort' => Hash::make('peter09')
        ));

        Mitglied::create(array(
            'vorname' => 'Hallo',
            'nachname' => 'Welt',
            'rolle' => 'Staffelleitung',
            'email' => 'hallo.welt@tester.com',
            'passwort' => Hash::make('peter09')
        ));

    }
}
