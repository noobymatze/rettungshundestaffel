@extends('layouts.desktop-skeleton')

@section('body')

<style>
.login-div {
    margin-left: auto;
margin-right: auto;
max-width: 20em;
border-style: solid;
border-color: #B4B4B4;
background-color: #F5F8F8;
border-radius: 0.3em;
border-width: 2px;
padding: 1em;
}
#login-header {
    text-align: center;
    margin: 2em 0;
}
#login-subtitle {
    color: #666;
    font-size: 1.6em;
    margin: 0;
}
#login-headline {
    font-size: 2.8em;
    margin: 0;
    margin-bottom: 0.2em;
}
</style>
<header id="login-header">
    <h1 id="login-headline" class="centered">Rettungshundestaffel</h1>
    <h2 id="login-subtitle" class="centered">Flensburg - Tarp</h2>
</header>

<div class="login-div">
    {{ Form::model($mitglied, array('action' => 'LoginController@login', 'role' => 'form')) }}
        <legend>Anmeldung</legend>
        <section class="form-group @hasError('email') has-feedback">
            {{ Form::label('email', 'E-Mail:*') }}
            {{ Form::email('email', null, array('class' => 'form-control')) }}
            {{ Form::feedback($errors->has('email')) }}
        </section>
        <section class="form-group @hasError('passwort') has-feedback">
            {{ Form::label('passwort', 'Passwort:*') }}
            {{ Form::password('passwort', array('class' => 'form-control')) }}
            {{ Form::feedback($errors->has('passwort')) }}
        </section>

        <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
    {{ Form::close() }}
</div>

@stop
