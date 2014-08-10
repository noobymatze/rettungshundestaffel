@extends('layouts.desktop')

@section('head')
<style type="text/css">
#suchgebiet-seite #top-header {
    border-radius: 3px;
    border-style: solid;
    border-width: 1px;
    border-color: #d3d6db;
    background-color: white;
    margin-bottom: 1em;
}

#suchgebiet-seite #map-section {
    height: 17em;
    background-color: #ddd;
    position: relative;
}

#suchgebiet-seite #map-section-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    color: #eee;
    margin: 0.5em 1.3em;
}

#suchgebiet-seite #map-section-footer h1 {
    font-size: 2em;
    margin: 0.2em 0;
}

#suchgebiet-seite #map-section-footer p {
    font-size: 1em;
    margin: 0.2em 0;
}

#suchgebiet-seite #suchgebiet-nav ul {
    padding: 0;
    margin: 0;
}

#suchgebiet-seite #suchgebiet-nav ul li {
    list-style: none;
    display: inline-block;
    border-right-style: solid;
    border-width: 1px;
    border-color: #e9eaed;
    padding: 0.5em 1.1em;
    color: #555;
    margin: 0;
    font-size: 1.2em;
}

#suchgebiet-seite #suchgebiet-nav ul li:hover {
    background-color: #f7f7f7;
}

#map {
    height: 100%;
}

#map-section-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0) 60%, rgba(0,0,0,0.65) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(60%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0) 60%,rgba(0,0,0,0.65) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0) 60%,rgba(0,0,0,0.65) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0) 60%,rgba(0,0,0,0.65) 100%); /* IE10+ */
    background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0) 60%,rgba(0,0,0,0.65) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 ); /* IE6-9 */
}

.suchgebiet-section {
    border-radius: 3px;
    border-style: solid;
    border-width: 1px;
    border-color: #d3d6db;
    background-color: white;
}

.suchgebiet-section-header {
    background-color: #eee;
    position: relative;
}

.suchgebiet-section-header h2 {
    margin: 0;
    font-size: 1.5em;
    padding: 0.5em;
}

.editable .edit {
    position: absolute;
    right: 0;
    top: 0;
}

.btn-area {
    text-align: center;
    padding: 1em;
    background-color: #fff;
}
</style>
@yield('suchgebiet-head')
@stop

@section('content')
<article id="suchgebiet-seite">
    <header id="top-header">
        <section id="map-section">
            @if ($flaechen != null)
                <div id="map"></div>
                <script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function (evt) {
                        var loadedPolygons = JSON.parse('{{$flaechen}}' || "null");
                        var boundingBox = JSON.parse('{{$boundingBox}}' || "null");

                        var map = L.map('map', {
                            scrollWheelZoom: false,
                            zoomControl: false,
                            attributionControl: false,
                        });

                        L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg', { maxZoom: 18, subdomains: '1234' }).addTo(map);

                        if (boundingBox !== null) {
                            map.fitBounds([
                                [boundingBox.miny, boundingBox.minx],
                                [boundingBox.maxy, boundingBox.maxx]
                            ])
                        }

                        // Initialise the FeatureGroup to store editable layers
                        var drawnItems = new L.FeatureGroup();
                        map.addLayer(drawnItems);

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
                    });
                </script>
            @else
                
            @endif
            <div id="map-section-overlay">
                <footer id="map-section-footer">
                    <h1>{{{$suchgebiet->name}}}</h1>
                    @if ($suchgebiet->adresse != null)
                        <p>{{{ $suchgebiet->adresse->strasse }}} {{{ $suchgebiet->adresse->hausnummer }}}{{{ $suchgebiet->adresse->zusatz }}}, {{{ $suchgebiet->adresse->postleitzahl }}} {{{ $suchgebiet->adresse->ort }}}</p>
                    @endif
                </footer>
            </div>
        </section>
        <nav id="suchgebiet-nav">
            <ul>
                <a href="{{URL::action('SuchgebieteDesktopController@renderSuchgebiet', array('id' => $suchgebiet->id))}}"><li>Info</li></a><a href="{{URL::action('SuchgebieteDesktopController@renderKarte', array('id' => $suchgebiet->id, 'name' => Str::slug($suchgebiet->name, '_')))}}"><li>Karte</li></a><li>Training</li><li>Personen</li><li>POI</li>
            </ul>
        </nav>
    </header>
    @yield ('suchgebiet-content')
</article>
@stop