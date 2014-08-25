@extends('layouts.desktop-skeleton')

@section('body')
<div id="wrapper">
	<!-- Sidebar -->
	@section('sidebar')
	<div id="sidebar-wrapper">
		<nav class="sidebar-nav nav pills">
			<li class="sidebar-brand">
				<img class="me-thumbnail" src="{{ Auth::user()->profilbild() }}"/>
				<a href="#">{{{Auth::user()->vorname}}}</a>
				<a class="logout-button" href="#" data-toggle="modal" data-target="#modalAusloggen"><i class="glyphicon glyphicon-off"></i></a>
			</li>
			<li class="@activeOnPath('dashboard*')">
				<a href=""><i class="icon-th-large"></i> Dashboard</a>
			</li>
			<li  class="@activeOnPath('mitglieder*')">
				<a href="{{ URL::action('MitgliederDesktopController@uebersicht') }}"><i class="icon-users"></i> Mitglieder</a>
			</li>
			<li  class="@activeOnPath('suchgebiete*')">
				<a href="{{ URL::action('SuchgebieteDesktopController@renderSuchgebiete') }}"><i class="icon-map"></i> Suchgebiete</a>
			</li>
			<li  class="@activeOnPath('termine*')">
				<a href="{{ URL::action('TermineDesktopController@uebersicht') }}"><i class="glyphicon glyphicon-calendar"></i> Termine</a>
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
					<a href="{{ URL::action('LoginController@ausloggen') }}" class="btn btn-primary">Ausloggen</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	@show
	<div id="page-content-wrapper">
		<!-- Der ganze Inhalt hier -->
		<div class="page-content inset">
			@yield('content')
		</div>
	</div>
</div>
@stop