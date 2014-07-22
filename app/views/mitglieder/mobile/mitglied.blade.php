@extends('layouts.mobile-navigation')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('stylesheets/mobile/mitgliedprofil.css') }}">
@stop

@section('header-center')
<h1>{{{ $mitglied->vollerName() }}}</h1>
@stop
@section('content')
<div class="first-row">
	<img class="pure-img image-left" src="{{{ $mitglied->profilbild() }}}">
	<address class="info-div kontakt-div">
		<h1>Kontakt</h1>
		<div>
			<h2>Mobil</h2>
			<p>{{{ $mitglied->mobil or '-' }}}</p>
			@if (isset($mitglied->mobil))
				<i onclick="window.open('tel:{{{$mitglied->mobil}}}')" class="icon-phone"></i>
			@endif
		</div>
		<div>
			<h2>Festnetz</h2>
			<p>{{{ $mitglied->telefon or '-' }}}</p>
			@if (isset($mitglied->telefon))
				<i onclick="window.open('tel:{{{$mitglied->telefon}}}')" class="icon-phone"></i>
			@endif
		</div>
		<div>
			<h2>E-Mail</h2>
			<p>{{{ $mitglied->email or '-' }}}</p>
			@if (isset($mitglied->email))
				<a href="mailto:{{{ $mitglied->email }}}"><i class="icon-phone"></i></a>
			@endif
		</div>
	</address>
</div>
@if (count($mitglied->Hunde) > 0)
<div class="info-div hunde-div">
	<h1>Hunde</h1>
	@foreach ($mitglied->Hunde as $hund)
	<div class="hund-div">
		<div class="hund-info-div">
			<img class="pure-img image-left" src="{{{ $hund->bild() }}}">
			<address class="info-div">
				<h2>Name</h2>
				<p>{{{$hund->name}}}</p>
				<h2>Rasse</h2>
				<p>{{{$hund->rasse}}}</p>
				<h2>Alter</h2>
				<p>{{{$hund->alter}}}</p>
			</address>
		</div>
		<address class="info-div sucharten-div">
			<h2>Sucharten</h2>
			@if (count($hund->Sucharten) > 0)
				@foreach ($hund->Sucharten as $suchart)
				<div>
					<p>{{{$suchart->name}}}</p>
				</div>
				@endforeach
			@else
				<p>Keine Suchart</p>
			@endif
		</address>
	</div>
	@endforeach
</div>
@else
	<p class="einzug-links">{{{ $mitglied->vollerName() }}} hat bisher keine Hunde eingetragen.</p>
@endif
@stop