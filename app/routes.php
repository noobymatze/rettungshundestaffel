<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function () 
{
    Route::get('/mitglieder', 'MitgliederDesktopController@uebersicht');
	Route::get('/mitglieder/anlegen', 'MitgliederDesktopController@renderErstelleMitglied');
	Route::get('/mitglieder/{id}', 'MitgliederDesktopController@renderMitglied');
	Route::post('/mitglieder/filtere', 'MitgliederDesktopController@filtereUebersicht');
	Route::post('/mitglieder/anlegen', 'MitgliederDesktopController@erstelleMitglied');
});

Route::get('/login', 'LoginController@renderLogin');
Route::post('/login', 'LoginController@login');
Route::get('/ausloggen', 'LoginController@ausloggen');

//Route::get('mobile/login', 'LoginControllerMobile@renderLogin');
//Route::post('mobile/login', 'LoginControllerMobile@login');
//Route::get('mobile/ausloggen', 'LoginControllerMobile@ausloggen');

