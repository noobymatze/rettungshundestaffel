@extends('layouts.desktop')

@section('title')
Mitglieder
@stop

@section('content')
    <section class="row">
        {{ Form::open(['action' => 'MitgliederDesktopController@uebersicht', 'name' => 'uebersicht-suche', 'class' => 'form col-md-6', 'method' => 'GET']) }}
            <span class="input-group col-md-6">
                {{ Form::text('suchbegriff', $suchbegriff, array('class' => 'form-control', 'placeholder' => 'Suche...')) }}
                <div class="input-group-btn">
                    <button class="btn btn-default" name="suche"><span class="glyphicon glyphicon-search"></span></button>
                </div>
            </span>
        {{ Form::close() }}
    </section>

    <section class="mitglieder">
        @include('mitglieder.desktop.liste', ['mitglieder' => $mitglieder])
    </section>
    <script src="{{ URL::asset('javascripts/mitglieder.js') }}"></script>
@stop
