@extends('layouts.mobile-navigation')

@section('header-center')
<h1>{{ $suchgebiet->name }}</h1>
@stop

@section('content')
<div id="map" class="suchgebiet-karte"></div>

<section class="suchgebiet">

    
    <script src="{{ URL::asset('javascripts/mobile/suchgebiete.min.js') }}"></script>
</section>
@stop


