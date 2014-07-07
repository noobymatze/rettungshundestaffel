@extends('layouts.desktop')

@section('title')
Mitglieder
@stop

@section('content')
    @foreach($mitglieder as $mitglied)
    <section class="media mitglied col-md-4">
        <img class="pull-left col-md-4 media-object" src="{{ $mitglied->profilbild() }}"/>
        <section class="media-body">
            <h3 class="media-heading">{{ $mitglied->vollerName() }}</h3>
            <span class="row col-md-12">{{ $mitglied->email }}</span>
            <span class="row col-md-12"><span class="glyphicon glyphicon-earphone"></span> {{ $mitglied->telefon }}</span>
        </section>
    </section>
    @endforeach
@stop
