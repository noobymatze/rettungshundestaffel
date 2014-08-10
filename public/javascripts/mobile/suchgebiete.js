!function(D, L, config) {
    'use strict';

    var FLENSBURG = [54.7803950, 9.4357070];

    // Default Werte setzen:
    config.flaechen = config.flaechen || [];
    config.center = config.center || FLENSBURG;
    config.zoom = config.zoom || 15;

    if(config.flaechen.length > 0) {
        var koordinate = config.flaechen[0].koordinaten[0];
        config.center = [koordinate.latitude, koordinate.longitude];
    }

    // Karteninitialisierung:
    var map = L.map('map', { scrollWheelZoom: false })
            .setView(config.center, config.zoom);

    var tileURL = 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg'; 
    L.tileLayer(tileURL, { maxZoom: 18, subdomains: '1234' }).addTo(map);

    var flaechen = config.flaechen
            .map(get('koordinaten'))
            .map(function(k) { return k.map(koordinateZuLatLng); })
            .map(L.polygon);

    L.featureGroup(flaechen).addTo(map);
    
    // =========================================================================
    // Helper Funktionen:
    // =========================================================================
    function koordinateZuLatLng(koordinate) {
        return L.latLng(koordinate.latitude, koordinate.longitude);
    }

    function get(prop) {
        return function(obj) {
            return obj[prop];
        };
    }
}(document, L, SuchgebieteConfig || {});

