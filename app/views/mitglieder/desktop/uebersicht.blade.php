@extends('layouts.desktop')

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
        @ifstaffelleitung
        <div class="col-md-3 pull-right">
            <a class="btn btn-primary btn-right" href="{{ URL::action('MitgliederDesktopController@renderErstelleMitglied') }}">
                <i class="glyphicon glyphicon-plus"></i> Mitglied anlegen
            </a>
        </div>
        @endif
    </section>

    <section class="mitglieder">
        @include('mitglieder.desktop.liste', ['mitglieder' => $mitglieder])
    </section>
@stop
