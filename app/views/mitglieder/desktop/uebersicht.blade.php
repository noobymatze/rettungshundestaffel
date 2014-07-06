@extends('layouts.master')

@section('content')
    <h1 class="ui header">{{ $title }}</h1>
    @foreach($mitglieder as $mitglied)
        <section class="mitglied">
            <img class="" src="{{ $mitglied->profilbild }}"/>
            <section class="">
                {{ $mitglied->vollerName() }}
            </section>
        </section>
    @endforeach
@stop
