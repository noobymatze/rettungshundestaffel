@extends('layouts.desktop')

{{-- Empty Title --}}
@section('title')
@stop

{{-- Die Sidebar überschreiben (entfernen), weil im Login nicht gebraucht wird. --}}
@section('sidebar')
    
@stop

@section('content')

{{ Form::model($mitglied, array('action' => 'LoginController@login', 'class' => 'form-horizontal col-md-6')) }}
    <section class="form-group row @hasError('email') has-feedback">
        {{ Form::label('email', 'E-Mail:*', array('class' => 'col-md-2')) }}
        <span class="col-md-6">
            {{ Form::email('email', null, array('class' => 'form-control')) }}
            {{ Form::feedback($errors->has('email')) }}
        </span>
    </section>
    <section class="form-group row @hasError('passwort') has-feedback">
        {{ Form::label('passwort', 'Passwort:*', array('class' => 'col-md-2')) }}
        <span class="col-md-6">
            {{ Form::password('passwort', array('class' => 'form-control')) }}
            {{ Form::feedback($errors->has('passwort')) }}
        </span>
    </section>

    <section class="form-group row">
        <div class="col-md-8">
            <button class="btn btn-primary col-md-12">Anmelden</button>
        </div>
    </section>
{{ Form::close() }}

@stop
