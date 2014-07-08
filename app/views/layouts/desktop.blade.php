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
				<nav class="sidebar-nav nav pills">
					<li class="sidebar-brand">
						<a href="#">Rettungshundestaffel</a>
					</li>
					<li>
						<a href=""><i class="glyphicon glyphicon-home"></i> Dashboard</a>
					</li>
					<li>
						<a href="{{ URL::action('MitgliederDesktopController@uebersicht') }}"><i class="glyphicon glyphicon-user"></i> Mitglieder</a>
					</li>
					<li>
						<a href="suchgebiete"><i class="glyphicon glyphicon-tree-conifer"></i> Suchgebiete</a>
					</li>
					<li>
						<a href="termine"><i class="glyphicon glyphicon-calendar"></i> Termine</a>
					</li>
					<hr>
					<li>
						<a href="#" data-toggle="modal" data-target="#modalAusloggen"><i class="glyphicon glyphicon-off"></i> Ausloggen</a>
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
			<!-- Modal-Dialog zum Ausloggen -->
			<div class="modal fade" id="modalAusloggen">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title">Ausloggen</h4>
						</div>
						<div class="modal-body">
							<p>Wollen Sie sich wirklich ausloggen?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
							<a href="ausloggen" class="btn btn-primary">Ausloggen</a>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
            @show
            <div id="page-content-wrapper">
                <div class="content-header">
                    <h1>
						<a href="#"><a id="menu-toggle" href="#" class="btn btn-default"><i class="glyphicon glyphicon-resize-horizontal"></i></a>
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