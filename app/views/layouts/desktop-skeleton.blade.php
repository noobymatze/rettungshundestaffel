<!DOCTYPE html>
<html>
    <head>
        <title>Rettungshundestaffel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ URL::asset('javascripts/leaflet/leaflet.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/main.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/simple-sidebar.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap-datetimepicker.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/icons.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('javascripts/leaflet-draw/leaflet.draw.css') }}">
        <script src="{{ URL::asset('javascripts/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ URL::asset('javascripts/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('javascripts/leaflet/leaflet.js') }}"></script>
        <script src="{{ URL::asset('javascripts/leaflet-draw/leaflet.draw.js') }}"></script>
        @yield('head')
    </head>
    <body class="background-forest">
    	@yield('body')
        <script src="{{ URL::asset('javascripts/moment.min.js') }}"></script>
        <script src="{{ URL::asset('javascripts/transition.js') }}"></script>
        <script src="{{ URL::asset('javascripts/collapse.js') }}"></script>
        <script src="{{ URL::asset('javascripts/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ URL::asset('javascripts/bootstrap-datetimepicker.de.js') }}"></script>
    </body>
</html>