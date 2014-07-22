<!DOCTYPE html>
<html>
    <head>
        <title>Rettungshundestaffel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    </head>
    <!--<body class="pure-skin-blue">-->
    <body>
		@yield('body')
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/purecss/pure-min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/purecss/grids-responsive-min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/mobile/mobile.css') }}">
        <!--<link rel="stylesheet" href="{{ URL::asset('stylesheets/mobile/pure-blue.css') }}">-->
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/mobile/icons.css') }}">
        @yield('css')
    </body>
</html>