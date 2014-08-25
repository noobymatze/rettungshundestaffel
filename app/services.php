<?php

App::bind('mitgliederService', function () {
    return new MitgliederService;
});

App::singleton('osmService', function() {
    return new OSMSearchService();
});
