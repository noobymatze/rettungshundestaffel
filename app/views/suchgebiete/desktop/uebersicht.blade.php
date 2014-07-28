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
<h1>Suchgebiete 
@if (Auth::user()->rolle == 'Staffelleitung')
    <a href="{{ URL::action('SuchgebieteDesktopController@renderAddSuchgebiet') }}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Neues Suchgebiet hinzufügen</a>
@endif
</h1>
<!--<div id="map"></div>-->
<ul class="suchgebiete-liste">
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Tarper Wald</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Susis Wiese</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Flensburg City</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Tarper Wald</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Susis Wiese</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Flensburg City</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Tarper Wald</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Susis Wiese</h2>
    </li>
    <li>
        <img src="http://placehold.it/200x170">
        <h2>Flensburg City</h2>
    </li>
</ul>
@stop
