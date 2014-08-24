@extends('layouts.mobile-navigation')

@section('header-center')
<h1>Suchgebiete</h1>
@stop

@section('content')
<section class="suchgebiet-liste pure-g">
    @foreach($suchgebiete as $index => $suchgebiet) 
        <a href="{{ URL::action('SuchgebieteMobilController@details', [$suchgebiet->id]) }}" class="suchgebiet__details pure-u-24-24">
            <b>{{ $suchgebiet->name }}</b>
            @if($suchgebiet->hatAnsprechpartner())
                <p>{{ $suchgebiet->ansprechpartner->vollerName() }}
                @if($suchgebiet->ansprechpartner->mobil)
                    <span data-href="tel:{{$suchgebiet->ansprechpartner->mobil}}" class="icon-phone--small">{{ $suchgebiet->ansprechpartner->mobil }}</span>
                @elseif($suchgebiet->ansprechpartner->telefon)
                    <span data-href="tel:{{$suchgebiet->ansprechpartner->telefon}}" class="icon-phone--small">{{ $suchgebiet->ansprechpartner->telefon }}</span>
                @endif
                </p>
            @endif
            <p>{{ $suchgebiet->getArea() }}</p>
            <p>{{ $suchgebiet->eigenschaftenAsString() }}</p>
        </a>
    @endforeach
</section>
<script src="{{ URL::asset('javascripts/mobile/suchgebiete-uebersicht.js') }}"></script>
@stop
