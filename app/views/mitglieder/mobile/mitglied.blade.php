@extends('layouts.mobile-navigation')

@section('header-center')
<h1>{{{ $mitglied->vollerName() }}}</h1>
@stop
@section('content')
<style>
	.hinweis-paragraph {
		font-size: 0.9em;
		color: #333;
		margin-left: 0.3em;
	}
	.einzug-links {
		margin-left: 0.3em;
	}
	img.image-left {
		width: 8em;
		height: 8em;
		position: absolute;
		left: 0;
		top: 0;
	}
	.info-div p {
		margin: 0;
		margin-bottom: 0.3em;
		padding: 0;
		color: #333;
		font-size: 1em;
	}
	.info-div h2 {
		font-size: 0.75em;
		color:#666;
		margin: 0 0;
		padding: 0 auto;
	}
	.info-div h1 {
		font-size: 0.9em;
		color: #333;
		margin: 0.3em 0;
	}
	.info-div {
		font-style: normal;
	}
	.first-row, .hund-info-div {
		position: relative;
		padding: 0em 0;
		padding-left: 8.5em;
		/* height: 8em; */
		border-bottom: #ddd solid 1px;
		min-height: 8em;
		overflow: hidden;
	}
	.hunde-div>h1 {
		padding-left: 0.5em;
	}
	.kontakt-div>div {
		position: relative;
		padding-right: 3.5em;
		overflow-wrap:break-word;
	}
	.kontakt-div>div i {
		cursor: pointer;
		right: .5625em;
		font-size: 1em;
		top: 50%;
		margin-top: -1em;
		position: absolute;
	}
	.kontakt-div>div>a {
		text-decoration: none;
		color: black;
	}
	span.geprueft-circle {
		width: auto;
		background-color: green;
	}
	.hund-div, .first-row {
		border-bottom: #666 solid 2px;
	}
	.sucharten-div>* {
		padding-left: 0.5em;
	}
</style>

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