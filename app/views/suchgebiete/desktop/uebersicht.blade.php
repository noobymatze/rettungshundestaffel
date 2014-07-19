@extends('layouts.desktop')

@section('title')
Suchgebiete 
@if (Auth::user()->rolle == 'Staffelleitung')
    <button class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Neues Suchgebiet hinzufügen</button>
@endif
@stop

@section('content')
<style>
.suchgebiete-liste {
    list-style-type: none;
    float: left;
    padding: 0;
}
.suchgebiete-liste li {
    float: left;
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
</style>
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
