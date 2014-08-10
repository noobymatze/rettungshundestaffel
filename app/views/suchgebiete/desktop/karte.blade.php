
@extends('suchgebiete.desktop.suchgebiet-skeleton')

@section('suchgebiet-head')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<style type="text/css">
#read-map {
    height: 40em;
    margin: auto 0;
    position: relative;
}
.search-overlay {
    position: absolute;
top: 0;
left: 50%;
margin-left: -10.4em;
z-index: 1;
background-color: rgba(255, 255, 255, 0.76);
padding: 0.4em 1.3em;
border-style: solid;
border-top-style: none;
border-width: 2px;
border-color: rgba(0,0,0,0.1);
border-bottom-left-radius: 0.5em;
border-bottom-right-radius: 0.5em;
}

.search-overlay:hover {
    background-color: #f9f9f9;
}

.search-wrapper {
    position: relative;
}

.geocode-button {
    position: absolute;
top: 0;
right: 8px;
line-height: 23px;
cursor: pointer;
padding: 0;
background-color: transparent;
}

.geocode-input {
    padding-right: 2em;
font-size: 1.1em;
width: 16em;
}

#edit-karte-button {
    padding: 0.7em;
}

#edit-map {
    height: 40em;
    margin: auto 0;
    position: relative;
}

</style>
@stop

@section('suchgebiet-content')
<section class="suchgebiet-section">
    <header class="suchgebiet-section-header editable">
        <h2>Karte</h2>
        @if (Auth::user()->rolle == 'Staffelleitung')
            <a href="#" class="edit" id="edit-karte-button">bearbeiten</a>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function (evt) {
                    var editKarteButton = document.getElementById("edit-karte-button");
                    var editKarteSection = document.getElementById("edit-karte-section");
                    var karteSection = document.getElementById("karte-section");
                    var editAbbrechenButton = document.getElementById("edit-abbrechen-button");

                    var hideEditSection = function () {
                        editKarteSection.style.display = "none";
                        editKarteButton.style.display = "block";
                        karteSection.style.display = "block";
                    };

                    var showEditSection = function () {
                        karteSection.style.display = "none";
                        editKarteButton.style.display = "none";
                        editKarteSection.style.display = "block";
                        loadEditMap();
                        return false;
                    };

                    $(editKarteButton).on("click", function(event) {
                        event.preventDefault();
                        showEditSection();
                    });

                    editAbbrechenButton.addEventListener('click', hideEditSection);

                    $("#karte-form").submit(function() {
                        var url = "{{ URL::action('SuchgebieteDesktopController@editKarte', array('id' => $suchgebiet->id)) }}"; // the script where you handle the form input.

                        var polygons = [];
                        drawnItems.eachLayer(function (layer) {
                            polygons[polygons.length] = layer.toGeoJSON();
                        });

                        $('#flaeche-input').val(JSON.stringify(polygons));

                        $.ajax({
                               type: "POST",
                               url: url,
                               data: $("#karte-form").serialize(), // serializes the form's elements.
                               success: function(data) {
                                    console.log(data);
                                    if (data.success === true) {
                                        location.reload();
                                    } else if (data.success === false) {
                                        console.log(data);
                                        var karteError = document.getElementById('karte-error');
                                        karteError.innerHTML = data.error;
                                        karteError.style.display = "block";
                                    } else {

                                    }
                               }
                             });

                        return false; // avoid to execute the actual submit of the form.
                    });

                    var editMap = null;
                    var drawnItems = null;

                    var updateMap = function () {
                        var address = $('#edit-geocode-input').val();
                        console.log(address);
                        var geocoder = new google.maps.Geocoder();
                        if (geocoder) {
                            geocoder.geocode({ 'address': address}, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    console.log(results);
                                    document.getElementById('edit-geocode-input').value = results[0].formatted_address;
                                    var lat = results[0].geometry.location.k;
                                    var lng = results[0].geometry.location.B;
                                    var center = L.latLng(lat, lng)
                                    
                                    var southWest = L.latLng(results[0].geometry.viewport.xa.j, results[0].geometry.viewport.pa.j),
                                    northEast = L.latLng(results[0].geometry.viewport.xa.k, results[0].geometry.viewport.pa.k),
                                    bounds = L.latLngBounds(southWest, northEast);

                                    editMap.fitBounds(bounds);
                                    editMap.setView(center);
                                }
                                else
                                    console.log("Geocoding failed: " + status);
                            });
                        }
                    };

                    var updateFlaecheHiddenField = function () {
                        var polygons = [];
                        drawnItems.eachLayer(function (layer) {
                            console.log(layer.toGeoJSON());
                            polygons[polygons.length] = layer.toGeoJSON();
                        });
                        document.getElementById("flaeche").value = JSON.stringify(polygons);
                        console.log(JSON.stringify(polygons));
                    };

                    var loadEditMap = function () {
                        if (editMap == null) {
                            editMap = L.map('edit-map', {
                                scrollWheelZoom: false,
                            }).setView([54.7803950, 9.4357070], 13);
                            L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg', { maxZoom: 18, subdomains: '1234' }).addTo(editMap);
                            //L.tileLayer('http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 18 }).addTo(map);
                            //L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);

                            // Initialise the FeatureGroup to store editable layers
                            drawnItems = new L.FeatureGroup();
                            editMap.addLayer(drawnItems);

                            var loadedPolygons = JSON.parse('{{$flaechen or null}}');
                            console.log(loadedPolygons);

                            if (loadedPolygons !== null && $.isArray(loadedPolygons)) {
                                for (var i = 0; i < loadedPolygons.length; i++) {
                                    console.log(loadedPolygons[i].type);
                                    if (loadedPolygons[i].type == 'Polygon') {
                                        var latlngArray = [];
                                        var coordinates = loadedPolygons[i].coordinates[0];
                                        for (var j = 0; j < coordinates.length; j++) {
                                            latlngArray[j] = L.latLng(coordinates[j][1], coordinates[j][0]);
                                        }
                                        drawnItems.addLayer(L.polygon(latlngArray));
                                    }
                                }
                            }

                            // Initialise the draw control and pass it the FeatureGroup of editable layers
                            var drawControl = new L.Control.Draw({
                                draw : {
                                    polyline: false,
                                    rectangle: false,
                                    circle: false,
                                    marker: false,
                                    polygon: {
                                        showArea: true,
                                    },
                                },
                                edit: {
                                    featureGroup: drawnItems
                                }
                            });

                            editMap.addControl(drawControl);

                            editMap.on('draw:created', function (e) {
                                var type = e.layerType,
                                    layer = e.layer;

                                if (type === 'marker') {
                                    // Do marker specific actions
                                }

                                // Do whatever else you need to. (save to db, add to map etc)
                                drawnItems.addLayer(layer);

                                //console.log(drawnItems);

                                //updateFlaecheHiddenField();
                            });

                            //editMap.on('draw:edited', updateFlaecheHiddenField);

                            //editMap.on('draw:deleted', updateFlaecheHiddenField);

                            $("#edit-geocode-form").submit(function(evt) {
                                updateMap();
                                return false; // avoid to execute the actual submit of the form.
                            });
                        }
                    };
                });
            </script>
        @endif
    </header>
    <section id="karte-section">
        @if ($flaechen == null)
            <p>Keine Karteninformationen</p>
        @else
            <div id="read-map">
                <div class="search-overlay">
                    <form class="search-wrapper" id="read-geocode-form">
                        <input id="read-geocode-input" placeholder="Gehe zu..." class="holo" type="text" class="geocode-input">
                        <button id="read-geocode-button" class="btn geocode-button"><i class="glyphicon glyphicon-search"></i></button>
                    </form>
                </div>
            </div>
        @endif
    </section>
    @if (Auth::user()->rolle == 'Staffelleitung')
        <section id="edit-karte-section" style="display:none;">
            <div id="edit-map">
                <div class="search-overlay">
                    <form class="search-wrapper" id="edit-geocode-form">
                        <input id="edit-geocode-input" placeholder="Gehe zu..." class="holo" type="text" class="geocode-input">
                        <button id="edit-geocode-button" class="btn geocode-button"><i class="glyphicon glyphicon-search"></i></button>
                    </form>
                </div>
            </div>
            {{Form::open(array('action' => array('SuchgebieteDesktopController@editKarte', $suchgebiet->id), 'id' => 'karte-form', 'class' => 'btn-area'))}}
                <input type="hidden" name="flaeche" id="flaeche-input">
                <button class="btn btn-primary btn-xs">Änderungen speichern</button>
                <button class="btn btn-default btn-xs" type="button" id="edit-abbrechen-button">Abbrechen</button>
            {{Form::close()}}
        </section>
    @endif
</section>
@stop