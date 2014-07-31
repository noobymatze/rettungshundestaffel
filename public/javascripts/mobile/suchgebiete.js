var L = require('./../leaflet/leaflet.js');

var init = function() {
    var zoom = 13, center = [54.7803950, 9.4357070]; // Flensburg
    var map = L.map('map', { scrollWheelZoom: false, })
            .setView(center, zoom);

    L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg', 
                { maxZoom: 18, subdomains: '1234' }).addTo(map);
};

module.exports.callback = function() { return init; };