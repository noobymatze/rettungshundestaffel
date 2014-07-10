@extends('layouts.mobile-navigation')

@section('header-center')
<h1>Mitglieder</h1>
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
</style>
{{ Form::open(
	array('action' => array(
		'MMitgliederController@renderMitglieder'),
		'class' => 'pure-form search-form',
		'method' => 'GET')
) }}
    {{ Form::text('suchbegriff', null, array('placeholder' => 'Name...', 'class' => 'pure-input-rounded')) }}
    {{ Form::submit('Suchen', array('id' => 'search-button', 'class' => 'pure-button')) }}
{{ Form::close() }}
<!--
<form class="pure-form search-form">
    <input type="text" class="pure-input-rounded">
    <button id="search-button" type="submit" class="pure-button">Suche</button>
</form>-->
<style>
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
		/* min-height: 3.4em; */
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
		/* max-height: 3.5em; */
		left: 0;
		bottom: 0;
		width: 4em;
		height: .8em;
		background-color: rgba(255, 255, 255, 0.8);
		/*
		min-height: 5em;
		min-width: 5em;
		background: rgba(255,255,255,0);
background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 80%, rgba(26,26,26,0.43) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,255,255,0)), color-stop(80%, rgba(255,255,255,0)), color-stop(100%, rgba(26,26,26,0.43)));
background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 80%, rgba(26,26,26,0.43) 100%);
background: -o-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 80%, rgba(26,26,26,0.43) 100%);
background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 80%, rgba(26,26,26,0.43) 100%);
background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 80%, rgba(26,26,26,0.43) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#1a1a1a', GradientType=0 );
*/
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
	/* margin-top: 0.4em; */
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
.trail-circle, .flaeche-circle, .truemmer-circle {
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
</style>
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
		<a>
			<img class="pure-img" src="{{ URL::asset('images/guy.jpg') }}">
			<!--<div class="img-overlay">-->
			<!--</div>-->
			<h2>{{{ $user->vollerName() }}}
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
			<p>0173-8463748</p>
			<i class="icon-th-large"></i>
		</a>
	</li>
	@endforeach
</ul>
@endforeach
@stop