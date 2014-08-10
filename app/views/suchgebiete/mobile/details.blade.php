@extends('layouts.mobile-navigation')

@section('header-center')
<h1>{{ $suchgebiet->name }}</h1>
@stop

@section('content')
<div id="map" class="suchgebiet-karte"></div>
<section class="suchgebiet">
    <section class="suchgebiet__flaeche">
        Flaeche: 12,3 km&sup2;
    </section>
    <section class="suchgebiet__treffpunkt"></section>
    <section class="suchgebiet__landschaft">
        {{ $suchgebiet->landschaftseigenschaftenAsString() }}
    </section>
    <section class="suchgebiet__beschreibung">
        Beschreibung: {{ $suchgebiet->beschreibung }}
    </section>
    <section class="suchgebiet__personen">

    </section>
</section>

<script>
    var SuchgebieteConfig = {
        center: null,
        flaechen: {{ $suchgebiet->getFlaechenAlsArray() }}
    };
</script>
<script src="{{ URL::asset('javascripts/leaflet/leaflet.js') }}"></script>
<script src="{{ URL::asset('javascripts/mobile/suchgebiete.js') }}"></script>
@stop


