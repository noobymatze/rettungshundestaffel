@extends('layouts.mobile-navigation')

@section('header-center')
	<h1>Weiteres</h1>
@stop
@section('content')
	<a href="{{ URL::action('MLoginController@ausloggen') }}">
		<button class="pure-button pure-button-primary">Ausloggen</button>
	</a>
@stop