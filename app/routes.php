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

/*
| Desktop-Routes
*/
Route::get('/login', 'LoginController@renderLogin');
Route::post('/login', 'LoginController@login');
Route::get('/ausloggen', 'LoginController@ausloggen');

Route::group(array('before' => 'auth'), function () 
{
    Route::get('/mitglieder', 'MitgliederDesktopController@uebersicht');
	Route::get('/mitglieder/{id}', 'MitgliederDesktopController@renderMitglied')->where('id', '[0-9]+');
	Route::post('/mitglieder/{id}', 'MitgliederDesktopController@aktualisiere')->where('id', '[0-9]+');
	Route::get('/mitglieder/{id}/bearbeiten', 'MitgliederDesktopController@renderMitgliedBearbeiten');
	Route::post('/mitglieder', 'MitgliederDesktopController@filtereUebersicht');

	Route::group(array('before' => 'staffelleitung'), function()
	{
		Route::get('/mitglieder/anlegen', 'MitgliederDesktopController@renderErstelleMitglied');
		Route::post('/mitglieder/anlegen', 'MitgliederDesktopController@erstelleMitglied');
	});

});

/*
| Mobile-Routes
*/
Route::get('/mobile/login', 'MLoginController@renderLogin');
Route::get('/mobile', 'MLoginController@renderLogin');
Route::post('/mobile/login', 'MLoginController@login');
Route::get('/mobile/ausloggen', 'MLoginController@ausloggen');
//Route::get('/mobile/dashboard', array('before' => 'auth', 'uses' => 'MDashboardController@renderDashboard'));
Route::get('/mobile/dashboard', 'MDashboardController@renderDashboard');
Route::get('/mobile/mitglieder', 'MMitgliederController@renderMitglieder');
Route::get('/mobile/weiteres', 'MWeiteresController@renderWeiteres');