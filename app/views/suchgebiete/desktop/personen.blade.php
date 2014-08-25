@extends('suchgebiete.desktop.suchgebiet-skeleton')

@section('suchgebiet-head')
@stop

@section('suchgebiet-content')

<section class="suchgebiet-section">
    <header class="suchgebiet-section-header editable">
        <h2>Personen</h2>
    </header>
    @foreach($suchgebiet->personen as $person) 
        <header class="editable">{{ $person->vollerName() }}</header>
        <section class=""
    @endforeach
    <section class="suchgebiet-info-content">
        <section class="info-spalte">

        </section>

        {{ Form::model(['action' => ['SuchgebieteDesktopController@editPerson', 'id' => $suchgebiet->id], 'name' => 'person']) }}
        <div>
            <label for='vorname'>Vorname: </label>
            <input class="holo" type="text" name="vorname"/>
        </div>
        <div>
            <label for='nachname'>Nachname: </label>
            <input class="holo"  type="text" name="nachname"/>
        </div>
        <div>
            <label for='telefon'>Telefon: </label>
            <input class="holo"  type="text" name="telefon"/>
        </div>
        <div>
            <label for='mobil'>Mobil: </label>
            <input class="holo"  type="text" name="mobil"/>
        </div>
        <div>
            <label for='suchgebiet'>Suchgebiet: </label>
        </div>
        <div>
            <label for='adresse'>Adresse: </label>
            <input class="holo"  type="text" name="adresse"/>
        </div>
        {{ Form::close() }}
    </section>
</section>

@stop
