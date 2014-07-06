@extends('layouts.desktop')

{{-- Empty Title --}}
@section('title')
@stop

{{-- Die Sidebar überschreiben (entfernen), weil im Login nicht gebraucht wird. --}}
@section('sidebar')
    
@stop

@section('content')

{{ Form::model($mitglied, array('action' => 'LoginController@login', 'class' => 'form col-md-6')) }}

    <section class="form-group @hasError('email')">
        {{ Form::label('email', 'E-Mail:', array('class', 'control-label') }}
        {{ Form::email('email', array('class', 'form-control') }}
    </section>
    <section class="form-group @hasError('passwort')">
        {{ Form::label('passwort', 'Passwort:', array('class', 'control-label') }}
        {{ Form::password('passwort', array('class', 'form-control') }}
    </section>

    @if($errors->has()) 
        @foreach($errors->all() as $message)
            <p>{{ $message }}</p>
        @endforeach
    @endif

    {{ Form::submit('Anmelden', array('class' => 'ui green submit button')) }}
{{ Form::close() }}

@stop
