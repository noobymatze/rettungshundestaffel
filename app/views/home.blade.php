@extends('layouts.master')

@section('content')
    <h1 class="ui header">{{ $title }}</h1>
    @foreach($mitglieder as $mitglied)
        <section class="mitglied">
            <img class="mitglied__profilbild" src="{{ $mitglied->profilbild }}"/>
            <section class="mitglied__info">
            </section>
        </section>
    @endforeach
@stop
