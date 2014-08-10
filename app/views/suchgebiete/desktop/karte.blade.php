
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

                        $.ajax({
                               type: "POST",
                               url: url,
                               data: $("#karte-form").serialize(), // serializes the form's elements.
                               success: function(data) {
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
                        <input placeholder="Gehe zu..." class="holo" type="text" class="geocode-input">
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
                        <input placeholder="Gehe zu..." class="holo" type="text" class="geocode-input">
                        <button id="edit-geocode-button" class="btn geocode-button"><i class="glyphicon glyphicon-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="btn-area">
                <button class="btn btn-primary btn-xs">Änderungen speichern</button>
                <button class="btn btn-default btn-xs" type="button" id="edit-abbrechen-button">Abbrechen</button>
            </div>
        </section>
        <script type="text/javascript">
            var loadEditMap = function () {
                var map = L.map('edit-map', {
                    scrollWheelZoom: false,
                }).setView([54.7803950, 9.4357070], 13);
                L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg', { maxZoom: 18, subdomains: '1234' }).addTo(map);
                //L.tileLayer('http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 18 }).addTo(map);
                //L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);

                // Initialise the FeatureGroup to store editable layers
                var drawnItems = new L.FeatureGroup();
                map.addLayer(drawnItems);

                var loadedPolygons = JSON.parse({{{$flaechen or 'null'}}});
                console.log(loadedPolygons);

                if (loadedPolygons !== null && $.isArray(loadedPolygons)) {
                    for (var i = 0; i < loadedPolygons.length; i++) {
                        console.log(loadedPolygons[i].geometry.type);
                        if (loadedPolygons[i].geometry.type == 'Polygon') {
                            var latlngArray = [];
                            var coordinates = loadedPolygons[i].geometry.coordinates[0];
                            for (var j = 0; j < coordinates.length; j++) {
                                latlngArray[j] = L.latLng(coordinates[j][1], coordinates[j][0]);
                            }
                            drawnItems.addLayer(L.polygon(latlngArray));
                        }
                    }
                }

                var updateFlaecheHiddenField = function () {
                    var polygons = [];
                    drawnItems.eachLayer(function (layer) {
                        console.log(layer.toGeoJSON());
                        polygons[polygons.length] = layer.toGeoJSON();
                    });
                    document.getElementById("flaeche").value = JSON.stringify(polygons);
                    console.log(JSON.stringify(polygons));
                };

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
                map.addControl(drawControl);

                map.on('draw:created', function (e) {
                    var type = e.layerType,
                        layer = e.layer;

                    if (type === 'marker') {
                        // Do marker specific actions
                    }

                    // Do whatever else you need to. (save to db, add to map etc)
                    drawnItems.addLayer(layer);

                    updateFlaecheHiddenField();
                });

                map.on('draw:edited', updateFlaecheHiddenField);

                map.on('draw:deleted', updateFlaecheHiddenField);

                /*var marker = L.marker([51.5, -0.09]).addTo(map);
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
                    .openOn(map);*/

                var updateMap = function () {
                    var address = $('#edit-geocode-input').val();
                    var geocoder = new google.maps.Geocoder();
                    if (geocoder) {
                        geocoder.geocode({ 'address': address}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                console.log(results);
                                document.getElementById('geocode-input').value = results[0].formatted_address;
                                var lat = results[0].geometry.location.k;
                                var lng = results[0].geometry.location.B;
                                var center = L.latLng(lat, lng)
                                
                                var southWest = L.latLng(results[0].geometry.viewport.xa.j, results[0].geometry.viewport.pa.j),
                                northEast = L.latLng(results[0].geometry.viewport.xa.k, results[0].geometry.viewport.pa.k),
                                bounds = L.latLngBounds(southWest, northEast);

                                map.fitBounds(bounds);
                                map.setView(center);
                            }
                            else
                                console.log("Geocoding failed: " + status);
                        });
                    }
                };

                $("#edit-geocode-form").submit(function(evt) {
                    updateMap();
                    return false; // avoid to execute the actual submit of the form.
                });
            };
        </script>
    @endif
</section>
@stop