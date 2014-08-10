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
Route::get('/suchgebiete', 'SuchgebieteDesktopController@renderSuchgebiete');
//Route::get('/suchgebiete/anlegen', 'SuchgebieteDesktopController@renderAddSuchgebiet');
Route::post('/suchgebiete/anlegen', 'SuchgebieteDesktopController@add');
Route::get('/', 'LoginController@renderLogin');

Route::get('suchgebiete/{id}/{name?}', 'SuchgebieteDesktopController@renderSuchgebiet')->where('id', '[0-9]+')->where('name', '[\w-]+');
Route::get('suchgebiete/{id}/{name?}/karte', 'SuchgebieteDesktopController@renderKarte')->where('id', '[0-9]+')->where('name', '[\w-]+');
Route::post('suchgebiete/{id}/adresse', 'SuchgebieteDesktopController@editAdresse')->where('id', '[0-9]+');
Route::post('suchgebiete/{id}/beschreibung', 'SuchgebieteDesktopController@editBeschreibung')->where('id', '[0-9]+');
Route::post('suchgebiete/{id}/ansprechpartner', 'SuchgebieteDesktopController@editAnsprechpartner')->where('id', '[0-9]+');
Route::post('suchgebiete/{id}/karte', 'SuchgebieteDesktopController@editKarte')->where('id', '[0-9]+');
Route::post('suchgebiete/{id}/eigenschaften', 'SuchgebieteDesktopController@editEigenschaften')->where('id', '[0-9]+');

Route::group(array('before' => 'auth'), function () 
{
    Route::get('/mitglieder', 'MitgliederDesktopController@uebersicht');
	Route::get('/mitglieder/liste', 'MitgliederDesktopController@liste');

    Route::get('/mitglieder/{mitglied_id}/hunde/anlegen', 'HundeDesktopController@renderBearbeiten');
    Route::get('/mitglieder/{mitglied_id}/hunde/{hund_id}/bearbeiten', ['as' => 'hund-bearbeiten', 'uses' => 'HundeDesktopController@renderBearbeiten']);
    Route::post('/mitglieder/{mitglied_id}/hunde/{hund_id?}', 'HundeDesktopController@speichere')
            ->where('hund_id', '[0-9]+');
    Route::get('/mitglieder/{mitglied_id}/hunde/{hund_id}', 'HundeDesktopController@loesche')
            ->where('hund_id', '[0-9]+');

	Route::get('/mitglieder/{id}', 'MitgliederDesktopController@renderMitglied')->where('id', '[0-9]+');
	Route::post('/mitglieder/{id}', 'MitgliederDesktopController@aktualisiere')->where('id', '[0-9]+');
	Route::get('/mitglieder/{id}/bearbeiten', 'MitgliederDesktopController@renderMitgliedBearbeiten');

	Route::group(array('before' => 'staffelleitung'), function()
	{
        Route::get('/mitglieder/{id}/loesche', 'MitgliederDesktopController@loesche');
		Route::get('/mitglieder/anlegen', 'MitgliederDesktopController@renderErstelleMitglied');
		Route::post('/mitglieder/anlegen', 'MitgliederDesktopController@erstelle');
	});

});

/*
| Mobile-Routes
*/
Route::get('/mobile/login', 'MLoginController@renderLogin');
Route::get('/mobile', 'MLoginController@renderLogin');
Route::post('/mobile/login', 'MLoginController@login');
Route::get('/mobile/ausloggen', 'MLoginController@ausloggen');

Route::group(array('before' => 'auth.mobile'), function () {
	Route::get('/mobile/dashboard', 'MDashboardController@renderDashboard');
	Route::get('/mobile/mitglieder', 'MMitgliederController@renderMitglieder');
	Route::get('/mobile/weiteres', 'MWeiteresController@renderWeiteres');
	Route::get('/mobile/mitglieder/{id}', 'MMitgliederController@renderMitglied');

	Route::get('/mobile/suchgebiete'     , 'SuchgebieteMobilController@index');
	Route::get('/mobile/suchgebiete/{id}', 'SuchgebieteMobilController@details');
});
