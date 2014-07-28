@extends('layouts.desktop-skeleton')

@section('body')

<div class="image-wrapper">
    <header class="login-header">
        <h1 class="login-headline" class="centered">Rettungshundestaffel</h1>
        <h2 class="login-subtitle" class="centered">Flensburg - Tarp</h2>
    </header>

    {{ Form::model($mitglied, array('action' => 'LoginController@login', 'role' => 'form', 'class'=> 'login-form')) }}
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

    <section class="form-group">
        <button type="submit" class="btn btn-primary btn-block login__btn">Anmelden</button>
    </section>
    {{ Form::close() }}
    <img class="img-responsive" src="{{ URL::asset('images/wald-klein.jpg') }}"/>

</div>

@stop
