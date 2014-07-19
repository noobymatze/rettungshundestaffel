@extends('layouts.mobile-navigation')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('stylesheets/mobile/mitgliederliste.css') }}">
@stop

@section('header-center')
<h1>Mitglieder</h1>
@stop
@section('content')
{{ Form::open(
	array('action' => array(
		'MMitgliederController@renderMitglieder'),
		'class' => 'pure-form search-form',
		'method' => 'GET')
) }}
    {{ Form::text('suchbegriff', null, array('placeholder' => 'Name...')) }}
    {{ Form::submit('Suchen', array('id' => 'search-button', 'class' => 'pure-button')) }}
{{ Form::close() }}
@if (count($others) < 1 && isset($suchbegriff))
	<p class="hinweis-paragraph">Keine Ergebnisse für die Suche nach "{{{ $suchbegriff }}}".</p>
	<a href="{{ URL::action('MMitgliederController@renderMitglieder') }}" class="pure-button pure-button-primary einzug-links">Zurück</a>
@elseif (isset($suchbegriff))
	<p class="hinweis-paragraph">Ergebnisse für die Suche nach "{{{ $suchbegriff }}}":</p>
@endif
@foreach ($others as $letter => $firstLetterGroup)
<h2 class="letter">{{{ $letter }}}</h2>
<ul class="user-list">
	@foreach ($firstLetterGroup as $user)
	<?php $pruefungen = $user->holeGueltigePruefungen(); ?>
	<li>
		<a href="{{ URL::action('MMitgliederController@renderMitglied', array('mitglied_id' => $user->id)) }}">
			<img class="pure-img" src="{{{ $user->profilbild() }}}">
			<h2><span class="vorname">{{{ $user->vorname }}}</span> <span class="nachname">{{{ $user->nachname }}}</span>
			@if (isset($pruefungen['Mantrailing']))
				<span class="trail-circle">M</span>
			@endif
			@if (isset($pruefungen['Flaechensuche']))
				<span class="flaeche-circle">F</span>
			@endif
			@if (isset($pruefungen['Truemmersuche']))
				<span class="truemmer-circle">T</span>
			@endif			
			</h2>
			<p class="telefon">
			@if (isset($user->mobil))
				{{{ $user->mobil }}}</p>
				<i onclick="window.open('tel:{{{$user->mobil}}}')" class="icon-phone"></i>
			@elseif (isset($user->telefon))
				{{{ $user->telefon }}}</p>
				<i onclick="window.open('tel:{{{$user->telefon}}}')" class="icon-phone"></i>
			@else
				-</p>
			@endif
		</a>
	</li>
	@endforeach
</ul>
@endforeach
@stop