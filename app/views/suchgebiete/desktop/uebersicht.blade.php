@extends('layouts.desktop')

@section('head')
<style>
.suchgebiete-liste {
    list-style-type: none;
    padding: 0;
    text-align: center;
}
.suchgebiete-liste li {
    display: inline-block;
    border-width: 2px;
    border-radius: 0.3em;
    margin: 0 0.5em;
    margin-bottom: 1em;
    text-align: center;
}
.suchgebiete-liste h2 {
    font-size: 1em;
    margin: 0.8em 0;
}
#map {
    height: 20em;
    margin: 2em 0;
}
</style>
@stop

@section('content')
<script>
    /*window.onload = function (event) {
        var map = L.map('map').setView([51.505, -0.09], 13);
        L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg', { maxZoom: 18, subdomains: '1234' }).addTo(map);
        //L.tileLayer('http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 18 }).addTo(map);
        //L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
        var marker = L.marker([51.5, -0.09]).addTo(map);
        var circle = L.circle([51.508, -0.11], 500, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5
        }).addTo(map);
        var polygon = L.polygon([
            [51.509, -0.08],
            [51.503, -0.06],
            [51.51, -0.047]
        ]).addTo(map);
        marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
        circle.bindPopup("I am a circle.");
        polygon.bindPopup("I am a polygon.");
        var popup = L.popup()
            .setLatLng([51.5, -0.09])
            .setContent("I am a standalone popup.")
            .openOn(map);

    };*/
</script>
<header id="suchgebiete-uebersicht-header">
    <h1>Suchgebiete</h1>
    @if (Auth::user()->rolle == 'Staffelleitung')
        <button class="btn btn-primary" id="add-suchgebiet-button" {{{ $errors->has('bezeichnung') ? 'style=display:none;' : '' }}}>
            <i class="glyphicon glyphicon-plus"></i> Neues Suchgebiet anlegen
        </button>
        <section id="add-section" {{{ $errors->has('bezeichnung') ? '' : 'style=display:none;' }}}>
            {{ Form::model($suchgebiet, array('action' => 'SuchgebieteDesktopController@add', 'role' => 'form', 'id' => 'add-suchgebiet-form')) }}
                {{ Form::text('bezeichnung', null, array('class' => 'holo', 'id' => 'name-input', 'placeholder' => 'Name des Suchgebiets')) }}
                <button type='submit' class='btn btn-primary'>
                    <i class='glyphicon glyphicon-ok'></i>
                </button>
            {{ Form::close() }}
            <button id='cancel-button' class='btn'>Abbrechen</button>
            @if ($errors->has('bezeichnung'))
                <span>{{{$errors->first('bezeichnung')}}}</span>
            @endif
        </section>

        <script type="text/javascript">
            window.onload = function () {
                var addButton = document.getElementById('add-suchgebiet-button');
                var cancelButton = document.getElementById('cancel-button');
                var addSection = document.getElementById('add-section');
                var nameInput = document.getElementById('name-input');
                
                addButton.addEventListener('click', function (evt) {
                    addSection.style.display = 'inline-block';
                    addButton.style.display = 'none';
                    nameInput.focus();
                });

                cancelButton.addEventListener('click', function (evt) {
                    addButton.style.display = 'inline-block';
                    addSection.style.display = 'none';
                });
            };
        </script>
    @endif
</header>

<!--<div id="map"></div>-->
@if (sizeof($suchgebiete) < 1)
    <p>Es wurden noch keine Suchgebiete eingetragen</p>
@else
    <ul class="suchgebiete-liste">
    @foreach ($suchgebiete as $suchgebiet)
    <a href="{{ URL::action('SuchgebieteDesktopController@renderSuchgebiet', array('id' => $suchgebiet->id, 'name' => Str::slug($suchgebiet->name, '_'))) }}">
        <li>
            <img src="http://placehold.it/200x170">
            <h2>{{{ $suchgebiet->name }}}</h2>
        </li>
    </a>
    @endforeach
    </ul>
@endif
@stop
