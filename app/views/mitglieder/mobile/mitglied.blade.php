@extends('layouts.mobile-navigation')

@section('header-center')
<h1>{{{ $mitglied->vollerName() }}}</h1>
@stop
@section('content')
<style>
	form.search-form {
		position: relative;
		padding-right: 5em;
		height: 3em;
	}
	.search-form>input[type="submit"], #search-button {
		padding-left: 0.8em;
		position: absolute;
		right: 0;
		top: 0;
		width: 5em;
		height: 3em;
	}
	@media only screen and (max-width: 480px) {
		#search-button {
			margin: 0;
		}
	}

	.search-form>input[type="text"] {
		margin-right: 5em;
		height: 3.75em;
		width: 100%;
	}
	.user-list>li {
		overflow: visible;
		display: block;
		position: relative;
		overflow: visible;
	}
	.user-list>li>a {
		display: block;
		position: relative;
		overflow: hidden;
		margin: 0;
		padding: 0em 3.5em 0em 4.9em;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.user-list>li>a>i {
		right: .5625em;
		font-size: 1em;
		top: 50%;
		margin-top: -1em;
		position: absolute;
	}
	.user-list>li>a>img {
		position: absolute;
		max-height: 4em;
		max-width: 4em;
		left: 0;
		top: 0;
	}
	.user-list>li>a>.img-overlay {
		position: absolute;
		left: 0;
		bottom: 0;
		width: 4em;
		height: .8em;
		background-color: rgba(255, 255, 255, 0.8);
	}
	.user-list>li>a>h2 {
		font-size: 1em;
		margin: 0.5em 0;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		color: #333;
		text-shadow: 0 1px 0 #f3f3f3;
	}
	.user-list>li>a>p {
		font-size: 0.9em;
		margin: 0.5em 0;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		color: #666;
		text-shadow: 0 1px 0 #f3f3f3;
	}
	.user-list, .user-list>li {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.user-list>li {
		background-color: #f6f6f6;
		border-color: #ddd;
		border-width: 1px 0;
		border-style: solid;
	}
	.letter {
		font-size: .9em;
		margin: 0.4em 0em 0.4em 0.4em;
		padding: 0;
		color: #333;
	}
	.trail-circle, .flaeche-circle, .truemmer-circle, .geprueft-circle {
		border-radius: 1em;
		color: #FDFDFD;
		height: 1em;
		width: 1em;
		display: inline-block;
		font-size: .7em;
		font-weight: bold;
		padding: 0 0.1em;
		margin-top: -0.2em;
		margin-left: 0.0em;
		padding-bottom: 0.2em;
		vertical-align: middle;
		text-align: center;
		text-shadow: none;
	}
	.geprueft-circle {
		padding-left: 0.5em;
		padding-right: 0.5em;
	}
	.trail-circle {
		background-color: rgb(197, 52, 52);
	}
	.flaeche-circle {
		background-color: green;
	}
	.truemmer-circle {
		background-color: blue;
	}
	.circle-list {
		list-style: none;
		padding: 0;
		margin: 0;
		position: absolute;
		right: 3.8em;
		top: 0;
		bottom: 0;
	}
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
	}
	.kontakt-div>div>i {
		right: .5625em;
		font-size: 1em;
		top: 50%;
		margin-top: -1em;
		position: absolute;
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
	</address>
	<!--<address class="info-div">
		<h1>Adresse</h1>
		<h2>Straße</h2>
		<p>Landweg 14</p>
		<h2>Wohnort</h2>
		<p>24939 Flensburg-asdfsafasdfsadfasdf</p>
	</address>-->
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
	<p>{{{ $mitglied->vollerName() }}} hat bisher keine Hunde eingetragen.</p>
@endif
@stop