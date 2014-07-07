@extends('layouts.mobile-html-skeleton')

@section('body')

<h1 id="headline">Rettungshundestaffel</h1>
<h2 id="subline">{{{ $squadname }}}</h2>

{{ Form::model($mitglied, array('action' => 'MLoginController@login', 'class' => 'pure-form pure-form-stacked')) }}
    {{ Form::label('email', 'E-Mail') }}
    {{ Form::email('email', null, array('type' => 'email', 'placeholder' => 'E-Mail')) }}

    {{ Form::label('passwort', 'Passwort') }}
    {{ Form::password('passwort', array('type' => 'passwort', 'placeholder' => 'Passwort')) }}

    {{ Form::submit('Login', array('class' => 'pure-button pure-button-primary')) }}
{{ Form::close() }}
@stop