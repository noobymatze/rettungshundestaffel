@extends('layouts.mobile-skeleton')

@section('body')
<section>
	<header id="login-header">
		<h1 id="login-headline" class="centered">Rettungshundestaffel</h1>
		<h2 id="login-subtitle" class="centered">{{{ $squadname }}}</h2>
	</header>

	@if ($errors->any())
		<div class="notification notification-error">
			@if ($errors->has('email'))
		    	<p>Bitte geben Sie eine gültige E-Mail Adresse an.</p>
		    @endif
		    @if ($errors->has('passwort'))
		    	<p>Bitte geben Sie ein gültiges Passwort an.</p>
		    @endif
		    @if ($errors->has('autherror'))
		    	<p>E-Mail oder Passwort waren nicht korrekt.</p>
		    	<p>Bitte geben Sie Ihre Anmeldedaten erneut ein.</p>
		    @endif
		</div>
	@endif
	
	{{ Form::model($mitglied, array('action' => 'MLoginController@login', 'id' => 'login-form', 'class' => 'pure-form pure-form-stacked')) }}
		<fieldset>
		<legend>Anmeldung</legend>
	    {{ Form::label('email', 'E-Mail') }}
	    {{ Form::email('email', null, array('required' => 'true', 'type' => 'email', 'placeholder' => 'E-Mail', 'class' => 'pure-u-1-1')) }}

	    {{ Form::label('passwort', 'Passwort') }}
	    {{ Form::password('passwort', array('required' => 'true', 'type' => 'passwort', 'placeholder' => 'Passwort', 'class' => 'pure-u-1-1')) }}

	    {{ Form::submit('Login', array('id' => 'login-button', 'class' => 'pure-button pure-button-primary pure-u-1-1')) }}
	    </fieldset>
	{{ Form::close() }}
@stop