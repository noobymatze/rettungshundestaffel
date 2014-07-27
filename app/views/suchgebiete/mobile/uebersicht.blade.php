@extends('layouts.mobile-navigation')

@section('header-center')
<h1>Suchgebiete</h1>
@stop

@section('content')
    @foreach($suchgebiete as $suchgebiet) 
        <a class="suchgebiet" href="{{ URL::action('SuchgebieteMobilController@details', [$suchgebiet->id]) }}">
            <img class="suchgebiet__img" src=""/>
            <section class="suchgebiet__details">
                <b>{{ $suchgebiet->name }}</b>
            </section>
        </a>
    @endforeach
@stop
