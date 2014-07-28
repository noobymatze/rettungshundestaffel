@extends('layouts.desktop')

@section('head')
<style>
#suchgebiet-form .has-feedback .form-control-feedback {
	line-height: 24px;
}

label {
	margin-right: 5px; 
}

.content-header>h1>input {
	margin-left: 5px;
}

.form-inline .form-group {
	margin-right: 1em;
}

#map {
	height: 20em;
	margin: auto 0;
	position: relative;
}

input.holo[type='text']:before {
	content:"Achtung!";color:#ff0000;
}

input.holo[type='text'], textarea.holo {
    /*width: 200px; */
/* font-family: "Roboto", "Droid Sans", sans-serif; */
/* font-size: 16px; */
/* margin: 0; */
padding: 2px 8px 2px 8px;
/* position: relative; */
/* display: block; */
outline: none;
border: none;
background: bottom left linear-gradient(#a9a9a9, #a9a9a9) no-repeat, bottom center linear-gradient(#a9a9a9, #a9a9a9) repeat-x, bottom right linear-gradient(#a9a9a9, #a9a9a9) no-repeat;
background-size: 1px 6px, 1px 1px, 1px 6px;
}
input.holo[type='text']:hover, textarea.holo:hover, input.holo[type='text']:focus, textarea.holo:focus {
	background: bottom left linear-gradient(#0099cc, #0099cc) no-repeat, bottom center linear-gradient(#0099cc, #0099cc) repeat-x, bottom right linear-gradient(#0099cc, #0099cc) no-repeat;
	background-size: 1px 6px, 1px 1px, 1px 6px;	
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

#geocode-button {
	position: absolute;
top: 0;
right: 8px;
line-height: 23px;
cursor: pointer;
}

#geocode-input {
	padding-right: 2em;
font-size: 1.1em;
width: 16em;
}

</style>
@stop

@section('content')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
window.onload = function (event) {
    var map = L.map('map', {
    	scrollWheelZoom: false,
    }).setView([54.7803950, 9.4357070], 13);
    L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg', { maxZoom: 18, subdomains: '1234' }).addTo(map);
    //L.tileLayer('http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 18 }).addTo(map);
    //L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);

	// Initialise the FeatureGroup to store editable layers
	var drawnItems = new L.FeatureGroup();
	map.addLayer(drawnItems);

    var loadedPolygons = JSON.parse(document.getElementById("flaeche").value || "null");
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
    	var address = $('#geocode-input').val();
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
    // ------ Suche Addresse ------
    $("#geocode-button").click(function() {
    	updateMap();
    });

    var geocodeInput = document.getElementById('geocode-input').addEventListener('mousedown', function(evt) {
    	console.log("huh");
    	evt.stopPropagation();
    	return false;
    });

    document.getElementById("suchgebiet-form").onsubmit = function() {
    	if ($("#geocode-input").is(':focus')) {
    		updateMap();
        	return false;
    	}
    	else
    		return true;
    };
};
</script>
<h1>Neues Suchgebiet {{ Form::text('bezeichnung', null, array('class' => 'holo', 'form' => 'suchgebiet-form')) }}{{ Form::feedback($errors->has('bezeichnung')) }}
</h1>
@if($errors->any())
	<div class="alert alert-danger" role="alert">
	@foreach ($errors->all() as $error)
	<p>{{{ $error }}}</p>
	@endforeach
	</div>
@endif
{{ Form::model($suchgebiet, array('action' => 'SuchgebieteDesktopController@add', 'role' => 'form', 'id' => 'suchgebiet-form')) }}
    <!--<section class="form-group {{{ $errors->has('bezeichnung') ? 'has-error has-feedback' : ''}}}">
        {{ Form::label('bezeichnung', 'Bezeichnung') }}	
        {{ Form::text('bezeichnung', null, array('class' => 'form-control')) }}
        @if ($errors->has('bezeichnung'))
        	<span class="help-block">{{{ $errors->first('bezeichnung') }}}</span>
        @endif
        {{ Form::feedback($errors->has('bezeichnung')) }}
    </section>-->
    <div class="form-group">
    	<div class="form-inline">
	    <section class="form-group has-feedback">
	        {{ Form::label('plz', 'PLZ') }}	
	        {{ Form::text('plz', null, array('class' => 'holo')) }}
	        {{ Form::feedback($errors->has('plz')) }}
	    </section>
	    <section class="form-group has-feedback">
	        {{ Form::label('ort', 'Ort') }}	
	        {{ Form::text('ort', null, array('class' => 'holo')) }}
	        {{ Form::feedback($errors->has('ort')) }}
	    </section>
	    </div>
    </div>
    <div class="form-group">
        <div class="form-inline">
        <section class="form-group has-feedback">
            {{ Form::label('beschreibung', 'Beschreibung') }} 
            {{ Form::textarea('beschreibung', null, array('class' => 'holo form-control', 'rows' => 3)) }}
            {{ Form::feedback($errors->has('beschreibung')) }}
        </section>
        </div>
    </div>
    <section class="form-group has-feedback">
        {{ Form::label('flaeche', 'Fläche') }}
        {{ Form::hidden('flaeche') }}
        <div id="map">
        	<div class="search-overlay">
        		<div class="search-wrapper">
					<input placeholder="Gehe zu..." class="holo" type="text" id="geocode-input">
					<i id="geocode-button" class="glyphicon glyphicon-search"></i>
				</div>
        	</div>
        </div>
    </section>

    <button type="submit" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-ok"></i> Übernehmen</button>
{{ Form::close() }}
@stop