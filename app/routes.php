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
	Route::post('/mitglieder/anlegen', 'MitgliederDesktopController@erstelleMitglied');
});

Route::get('/login', 'LoginController@renderLogin');
Route::post('/login', 'LoginController@login');

