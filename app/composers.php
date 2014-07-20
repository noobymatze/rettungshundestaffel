<?php

$mitgliederSeiten = [
    'bearbeite-hund',
    'bearbeiten',
    'details',
    'erstelle',
    'liste',
    'uebersicht'
];

foreach($mitgliederSeiten as $seite) {
    View::composer('mitglieder.desktop.'.$seite, function ($view) {
        return $view->with('menu', MenuEnum::MITGLIEDER);
    });
}



