@extends('layouts.mobile-navigation')

@section('header-center')
<h1>{{ $suchgebiet->name }}</h1>
@stop

@section('content')
<div id="map" class="suchgebiet-karte"></div>
<section class="suchgebiet">
    <h4 class="suchgebiet__titel">Daten</h4>
    <section class="suchgebiet__landschaft">
        {{ $suchgebiet->eigenschaftenAsString() }}
    </section>
    <section class="suchgebiet__treffpunkt">
        Treffpunkt: {{ $suchgebiet->adresse }}
    </section>
    <section class="suchgebiet__beschreibung">
        {{ $suchgebiet->beschreibung }}
    </section>
    <section class="suchgebiet__personen">
        <section class="suchgebiet__personen__person">
            @foreach($suchgebiet->personen as $person)
                <h4 class="suchgebiet__titel">{{ $person->typ }}</h4>
                {{ $person->vollerName() }}
                @if($person->telefon)
                    <br>
                    Telefon: <a class="icon-phone--small" href="tel:{{$person->telefon}}">{{ $person->telefon }}</a>
                @endif
                @if($person->mobil)
                    <br>
                    Mobil: <a class="icon-phone--small" href="tel:{{$person->mobil}}">{{ $person->mobil }}</a>
                @endif
                <br>
                {{ $person->adresse }} 
            @endforeach
        </section>
    </section>
</section>

<script>
    var SuchgebieteConfig = {
        center: null,
        flaechen: {{ $flaechen }}
    };
</script>
<script src="{{ URL::asset('javascripts/leaflet/leaflet.js') }}"></script>
<script src="{{ URL::asset('javascripts/mobile/suchgebiete.js') }}"></script>
@stop


