
@extends('suchgebiete.desktop.suchgebiet-skeleton')

@section('suchgebiet-head')
<script type="text/javascript" src="{{ URL::asset('javascripts/bootstrap-tagsinput.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('javascripts/bootstrap-tagsinput.css') }}" />
<style type="text/css">
#suchgebiet-info-content .info-spalte {
    display: block;
    vertical-align: top;
    width: 50%;
    padding: 1em;
}

.info-spalte div {
    margin-top: 1.2em;
}

.info-spalte div:first-child {
    margin-top: 0;
}

.info-spalte h3 {
   font-size: 1.2em;
    margin: 0;
}

#suchgebiet-info-content>.info-spalte:first-child {
    display: block;
    vertical-align: top;
    width: 50%;
    padding: 1em;
    border-right: 1px solid #e5e5e5;
    float: left;
}

#suchgebiet-info-content>.info-spalte:last-child {
    display: block;
    vertical-align: top;
    width: 50%;
    padding: 1em;
    border-left: 1px solid #e5e5e5;
    float: right;
}

.info-spalte>div {
    border-bottom-style: solid;
    border-width: 1px;
    border-color: #d3d6db;
}

.clearfix:after {
    clear: both;
    content: ".";
    display: block;
    font-size: 0;
    height: 0;
    line-height: 0;
    visibility: hidden;
}

.editable {
    position: relative;
    padding-right: 5em;
}

.editable h3 {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.info-spalte header {
    margin-bottom: 0.5em;
}

.info-spalte header+section {
    margin-bottom: 0.5em;
}

.info-spalte header+section p {
    margin: 0;
}

.vertical-form>div {
    margin: 0;
    text-align: center;
}

.vertical-form label {
    font-weight: normal;
font-size: 1em;
min-width: 6em;
color: grey;
font-size: 0.9em;
text-align: right;
margin-right: 1em;
}

.edit-error {
    text-align: center;
border-radius: 0.5em;
background-color: #F3A0A0;
}

.bootstrap-tagsinput {
    width: 100%;
}

#beschreibung-area {
    width: 100%;
    min-height: 8em;
}

#eigenschaften-section>ul {
    padding: 0;
}

#eigenschaften-section>ul>li {
    list-style: none;
}
</style>
@stop

@section('suchgebiet-content')
<section class="suchgebiet-section">
    <header class="suchgebiet-section-header">
        <h2>Info</h2>
    </header>
    <section id="suchgebiet-info-content" class="clearfix">
        <section class="info-spalte">
            <div>
                <header class="editable">
                    <h3>Adresse</h3>
                    @if (Auth::user()->rolle == 'Staffelleitung')
                        <a href="#" class="edit" id="edit-adresse-button">bearbeiten</a>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function (evt) {
                                var editAdresseButton = document.getElementById("edit-adresse-button");
                                var editAdresseSection = document.getElementById("edit-adresse-section");
                                var adresseSection = document.getElementById("adresse-section");
                                var editAbbrechenButton = document.getElementById("edit-abbrechen-button");

                                var hideEditSection = function () {
                                    editAdresseSection.style.display = "none";
                                    editAdresseButton.style.display = "block";
                                    adresseSection.style.display = "block";
                                };

                                var showEditSection = function () {
                                    adresseSection.style.display = "none";
                                    editAdresseButton.style.display = "none";
                                    editAdresseSection.style.display = "block";
                                    return false;
                                };

                                $(editAdresseButton).on("click", function(event) {
                                    event.preventDefault();
                                    showEditSection();
                                });

                                editAbbrechenButton.addEventListener('click', hideEditSection);

                                $("#adresse-form").submit(function() {
                                    var url = "{{ URL::action('SuchgebieteDesktopController@editAdresse', array('id' => $suchgebiet->id)) }}"; // the script where you handle the form input.

                                    $.ajax({
                                           type: "POST",
                                           url: url,
                                           data: $("#adresse-form").serialize(), // serializes the form's elements.
                                           success: function(data) {
                                                if (data.success === true) {
                                                    location.reload();
                                                } else if (data.success === false) {
                                                    console.log(data);
                                                    var adresseError = document.getElementById('adresse-error');
                                                    adresseError.innerHTML = data.error;
                                                    adresseError.style.display = "block";
                                                } else {

                                                }
                                           }
                                         });

                                    return false; // avoid to execute the actual submit of the form.
                                });
                            });
                        </script>
                    @endif
                </header>
                <section id="adresse-section">
                    @if ($suchgebiet->adresse != null)
                        <p>{{{ $suchgebiet->adresse->strasse }}} {{{ $suchgebiet->adresse->hausnummer }}}{{{ $suchgebiet->adresse->zusatz }}}</p>
                        <p>{{{ $suchgebiet->adresse->postleitzahl }}} {{{ $suchgebiet->adresse->ort }}}</p>
                    @else
                        <p>Keine Adresse</p>
                    @endif
                </section>
                <section id="edit-adresse-section" style="display: none;">
                    {{Form::open(array('action' => array('SuchgebieteDesktopController@editAdresse', $suchgebiet->id), 'id' => 'adresse-form', 'class' => 'vertical-form'))}}
                        <div>
                            <label>Straße</label>
                            <input class="holo" type="text" placeholder="Straße" name="strasse" value="{{{ $suchgebiet->adresse->strasse or ''}}}">
                        </div>
                        <div>
                            <label>Hausnummer</label>
                            <input class="holo" type="text" placeholder="Hausnummer" name="hausnummer" value="{{{ $suchgebiet->adresse->hausnummer or ''}}}">
                        </div>
                        <div>
                            <label>Zusatz</label>
                            <input class="holo" type="text" placeholder="Zusatz" name="zusatz" value="{{{ $suchgebiet->adresse->zusatz or ''}}}">
                        </div>
                        <div>
                            <label>Postleitzahl</label>
                            <input class="holo" type="text" placeholder="Postleitzahl" name="plz" value="{{{ $suchgebiet->adresse->postleitzahl or ''}}}">
                        </div>
                        <div>
                            <label>Ort</label>
                            <input class="holo" type="text" placeholder="Ort" name="ort" value="{{{ $suchgebiet->adresse->ort or ''}}}">
                        </div>
                        <div class="btn-area">
                            <button class="btn btn-primary btn-xs">Änderungen speichern</button>
                            <button class="btn btn-default btn-xs" type="button" id="edit-abbrechen-button">Abbrechen</button>
                        </div>
                    {{ Form::close() }}
                    <p id="adresse-error" class="edit-error" style="display: none;"></p>
                </section>
            </div>
            <div>
                <header class="editable">
                    <h3>Eigenschaften</h3>
                    @if (Auth::user()->rolle == 'Staffelleitung')
                        <a href="#" class="edit" id="edit-eigenschaften-button">bearbeiten</a>
                    @endif
                </header>
                <section id="eigenschaften-section">
                    @if ($suchgebiet->landschaftseigenschaften != null && sizeof($suchgebiet->landschaftseigenschaften) > 0)
                        <ul>
                            @foreach ($suchgebiet->landschaftseigenschaften as $landschaftseigenschaft)
                                <li>{{{ $landschaftseigenschaft->name }}}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Keine Eigenschaften.</p>
                    @endif
                </section>

                @if (Auth::user()->rolle == 'Staffelleitung')
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function (evt) {

                            var eigenschaften = ('{{{$suchgebiet->landschaftseigenschaftenAsString()}}}').split(',');

                            console.log(eigenschaften);

                            for (var i = 0; i < eigenschaften.length; i++) {
                                $('#eigenschaften-input').tagsinput('add', eigenschaften[i]);
                            }

                            var editEigenschaftenButton = document.getElementById("edit-eigenschaften-button");
                            var editEigenschaftenSection = document.getElementById("edit-eigenschaften-section");
                            var eigenschaftenSection = document.getElementById("eigenschaften-section");
                            var eigenschaftenAbbrechenButton = document.getElementById("eigenschaften-abbrechen-button");

                            var hideEditSection = function () {
                                editEigenschaftenSection.style.display = "none";
                                editEigenschaftenButton.style.display = "block";
                                eigenschaftenSection.style.display = "block";
                            };

                            var showEditSection = function () {
                                eigenschaftenSection.style.display = "none";
                                editEigenschaftenButton.style.display = "none";
                                editEigenschaftenSection.style.display = "block";
                                return false;
                            };

                            $(editEigenschaftenButton).on("click", function(event) {
                                event.preventDefault();
                                showEditSection();
                            });

                            eigenschaftenAbbrechenButton.addEventListener('click', hideEditSection);



                            $("#eigenschaften-form").submit(function() {
                                var url = "{{ URL::action('SuchgebieteDesktopController@editEigenschaften', array('id' => $suchgebiet->id)) }}"; // the script where you handle the form input.

                                console.log($('#eigenschaften-select').val());

                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: $("#eigenschaften-form").serialize(), // serializes the form's elements.
                                    success: function(data) {
                                        if (data.success === true) {
                                            location.reload();
                                        } else if (data.success === false) {
                                            console.log(data);
                                            var eigenschaftenError = document.getElementById('eigenschaften-error');
                                            eigenschaftenError.innerHTML = data.error;
                                            eigenschaftenError.style.display = "block";
                                        } else {
                                            console.log("Unbekannter Fehler.");
                                        }
                                    }
                                });

                                return false; // avoid to execute the actual submit of the form.
                            });
                        });
                    </script>
                    <section id="edit-eigenschaften-section" style="display:none;">
                        {{Form::open(array('action' => array('SuchgebieteDesktopController@editEigenschaften', $suchgebiet->id), 'id' => 'eigenschaften-form', 'class' => 'vertical-form'))}}
                            <div>
                                <input style="width: 100%;" data-role="tagsinput" type="text" id="eigenschaften-input" name="eigenschaften">
                            </div>
                            <div class="btn-area">
                                <button class="btn btn-primary btn-xs">Änderungen speichern</button>
                                <button type="button" class="btn btn-default btn-xs" id="eigenschaften-abbrechen-button">Abbrechen</button>
                            </div>
                        {{Form::close()}}
                        <p id="eigenschaften-error" class="edit-error" style="display: none;"></p>
                    </section>
                @endif
            </div>
            <div>
                <header>
                    <h3>Fläche</h3>
                </header>
                <section id="flaeche-section">
                    <p>{{{$suchgebiet->getArea()}}} qm</p>
                </section>
            </div>
        </section>
        <section class="info-spalte">
            <div>
                <header class="editable">
                    <h3>Beschreibung</h3>
                    @if (Auth::user()->rolle == 'Staffelleitung')
                        <a href="#" class="edit" id="edit-beschreibung-button">bearbeiten</a>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function (evt) {
                                var editBeschreibungButton = document.getElementById("edit-beschreibung-button");
                                var editBeschreibungSection = document.getElementById("edit-beschreibung-section");
                                var beschreibungSection = document.getElementById("beschreibung-section");
                                var editAbbrechenButton = document.getElementById("beschreibung-abbrechen-button");

                                var hideEditSection = function () {
                                    editBeschreibungSection.style.display = "none";
                                    editBeschreibungButton.style.display = "block";
                                    beschreibungSection.style.display = "block";
                                };

                                var showEditSection = function () {
                                    beschreibungSection.style.display = "none";
                                    editBeschreibungButton.style.display = "none";
                                    editBeschreibungSection.style.display = "block";
                                    return false;
                                };

                                $(editBeschreibungButton).on("click", function(event) {
                                    event.preventDefault();
                                    showEditSection();
                                });

                                editAbbrechenButton.addEventListener('click', hideEditSection);

                                $("#beschreibung-form").submit(function() {
                                    var url = "{{ URL::action('SuchgebieteDesktopController@editBeschreibung', array('id' => $suchgebiet->id)) }}"; // the script where you handle the form input.

                                    $.ajax({
                                           type: "POST",
                                           url: url,
                                           data: $("#beschreibung-form").serialize(), // serializes the form's elements.
                                           success: function(data) {
                                                if (data.success === true) {
                                                    location.reload();
                                                } else if (data.success === false) {
                                                    console.log(data);
                                                    var beschreibungError = document.getElementById('beschreibung-error');
                                                    beschreibungError.innerHTML = data.error;
                                                    beschreibungError.style.display = "block";
                                                } else {

                                                }
                                           }
                                         });

                                    return false; // avoid to execute the actual submit of the form.
                                });
                            });
                        </script>
                    @endif
                </header>
                <section id="beschreibung-section">
                    @if ($suchgebiet->beschreibung != null)
                        <p>{{{$suchgebiet->beschreibung}}}</p>
                    @else
                        <p>Keine Beschreibung</p>
                    @endif                  
                </section>
                @if (Auth::user()->rolle == 'Staffelleitung')
                    <section id="edit-beschreibung-section" style="display: none;">
                        {{Form::open(array('action' => array('SuchgebieteDesktopController@editBeschreibung', $suchgebiet->id), 'id' => 'beschreibung-form', 'class' => 'vertical-form'))}}
                            <div>
                                <textarea id="beschreibung-area" class="holo" placeholder="Beschreibung" name="beschreibung" value="{{{ $suchgebiet->beschreibung or ''}}}">{{{ $suchgebiet->beschreibung or ''}}}</textarea>
                            </div>
                            <div class="btn-area">
                                <button class="btn btn-primary btn-xs">Änderungen speichern</button>
                                <button type="button" class="btn btn-default btn-xs" id="beschreibung-abbrechen-button">Abbrechen</button>
                            </div>
                            {{Form::close()}}
                            <p id="beschreibung-error" class="edit-error" style="display: none;"></p>
                    </section>
                @endif
            </div>
            <div>
                <header class="editable">
                    <h3>Ansprechpartner</h3>
                    @if (Auth::user()->rolle == 'Staffelleitung')
                        <a href="#" class="edit" id="edit-ansprechpartner-button">bearbeiten</a>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function (evt) {
                                var editAnsprechpartnerButton = document.getElementById("edit-ansprechpartner-button");
                                var editAnsprechpartnerSection = document.getElementById("edit-ansprechpartner-section");
                                var ansprechpartnerSection = document.getElementById("ansprechpartner-section");
                                var editAbbrechenButton = document.getElementById("ansprechpartner-abbrechen-button");

                                var hideEditSection = function () {
                                    editAnsprechpartnerSection.style.display = "none";
                                    editAnsprechpartnerButton.style.display = "block";
                                    ansprechpartnerSection.style.display = "block";
                                };

                                var showEditSection = function () {
                                    console.log("huhu");
                                    ansprechpartnerSection.style.display = "none";
                                    editAnsprechpartnerButton.style.display = "none";
                                    editAnsprechpartnerSection.style.display = "block";
                                    return false;
                                };

                                $(editAnsprechpartnerButton).on("click", function(event) {
                                    event.preventDefault();
                                    showEditSection();
                                });

                                editAbbrechenButton.addEventListener('click', hideEditSection);

                                $("#ansprechpartner-form").submit(function() {
                                    var url = "{{ URL::action('SuchgebieteDesktopController@editAnsprechpartner', array('id' => $suchgebiet->id)) }}"; // the script where you handle the form input.

                                    $.ajax({
                                           type: "POST",
                                           url: url,
                                           data: $("#ansprechpartner-form").serialize(), // serializes the form's elements.
                                           success: function(data) {
                                                if (data.success === true) {
                                                    location.reload();
                                                } else if (data.success === false) {
                                                    console.log(data);
                                                    var ansprechpartnerError = document.getElementById('ansprechpartner-error');
                                                    ansprechpartnerError.innerHTML = data.error;
                                                    ansprechpartnerError.style.display = "block";
                                                } else {

                                                }
                                           }
                                    });

                                    return false; // avoid to execute the actual submit of the form.
                                });
                            });
                        </script>
                    @endif
                </header>
                <section id="ansprechpartner-section">
                    @if ($suchgebiet->ansprechperson != null)
                        <p><a href="{{ URL::action('MitgliederDesktopController@renderMitglied', [$suchgebiet->ansprechperson->id]) }}">{{{$suchgebiet->ansprechperson->vorname}}} {{{$suchgebiet->ansprechperson->nachname}}}</a></p>
                    @else
                        <p>Kein Ansprechpartner</p>
                    @endif
                </section>
                <section id="edit-ansprechpartner-section" style="display: none;">
                    {{Form::open(array('action' => array('SuchgebieteDesktopController@editAnsprechpartner', $suchgebiet->id), 'id' => 'ansprechpartner-form', 'class' => 'vertical-form'))}}
                        <div>
                            <select id="ansprechpartner-select" name="ansprechpartner">
                                @foreach ($mitglieder as $mitglied)
                                    <option value="{{{$mitglied->id}}}"
                                        @if (isset($suchgebiet->ansprechperson) && $mitglied->id === $suchgebiet->ansprechperson->id)
                                            selected
                                        @endif
                                    >{{{$mitglied->vorname}}} {{{$mitglied->nachname}}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-area">
                            <button class="btn btn-primary btn-xs">Änderungen speichern</button>
                            <button type="button" class="btn btn-default btn-xs" id="ansprechpartner-abbrechen-button">Abbrechen</button>
                        </div>
                        {{Form::close()}}
                        <p id="ansprechpartner-error" class="edit-error" style="display: none;"></p>
                </section>
            </div>
        </section>
    </section>
</section>
@stop