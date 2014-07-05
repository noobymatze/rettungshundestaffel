@extends('layouts.master')

@section('content')

{{ Form::model($mitglied, array('action' => 'LoginController@login', 'class' => 'ui form segment')) }}

    <section class="field @hasError('email')">
        {{ Form::label('email', 'E-Mail:') }}
        {{ Form::text('email') }}
    </section>
    <section class="field @hasError('passwort')">
        {{ Form::label('passwort', 'Passwort:') }}
        {{ Form::password('passwort') }}
    </section>

    @if($errors->has()) 
        @foreach($errors->all() as $message)
            <p>{{ $message }}</p>
        @endforeach
    @endif

    {{ Form::submit('Anmelden', array('class' => 'ui green submit button')) }}
{{ Form::close() }}

@stop
