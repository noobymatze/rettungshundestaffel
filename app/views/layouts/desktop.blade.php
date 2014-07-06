<!DOCTYPE html>
<html>
    <head>
        <title>Rettungshundestaffel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div id="wrapper">
            <!-- Sidebar -->
            @section('sidebar')
                <div id="sidebar-wrapper">
                    <nav class="sidebar-nav">
                        <li class="sidebar-brand"><a href="#">Rettungshundestaffel</a>
                        </li>
                        <li><a href="#">Dashboard</a>
                        </li>
                        <li><a href="#">Mitglieder</a>
                        </li>
                        <li><a href="#">Suchgebiete</a>
                        </li>
                        <li><a href="#">Termine</a>
                        </li>
                    </nav>
                </div>
                <script>
                    window.addEventListener("DOMContentLoaded", function() {
                        $("#menu-toggle").click(function(e) {
                            e.preventDefault();
                            $("#wrapper").toggleClass("active");
                        });
                    });
                </script>
            @show
            <div id="page-content-wrapper">
                <div class="content-header">
                    <h1>
                    <a href="#"><a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
                    @section('title')
                        Titel
                    @show
                    </h1>
                </div>
                <!-- Der ganze Inhalt hier -->
                <div class="page-content inset">
                     @yield('content')
                </div>
            </div>
        </div>
       
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/main.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('stylesheets/simple-sidebar.css') }}">
        <script src="{{ URL::asset('javascripts/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ URL::asset('javascripts/bootstrap.min.js') }}"></script>

    </body>
</html>