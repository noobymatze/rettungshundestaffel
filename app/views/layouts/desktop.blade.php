@extends('layouts.desktop-skeleton')

@section('body')       
<div id="wrapper">
	<!-- Sidebar -->
	@section('sidebar')
	<div id="sidebar-wrapper">
		<nav class="sidebar-nav nav pills">
			<li class="sidebar-brand">
				<a href="#">Rettungshundestaffel</a>
			</li>
			<li class="{{{ $menu == MenuEnum::DASHBOARD ? 'active' : '' }}}">
				<a href=""><i class="glyphicon glyphicon-home"></i> Dashboard</a>
			</li>
			<li  class="{{{ $menu == MenuEnum::MITGLIEDER ? 'active' : '' }}}">
				<a href="{{ URL::action('MitgliederDesktopController@uebersicht') }}"><i class="glyphicon glyphicon-user"></i> Mitglieder</a>
			</li>
			<li  class="{{{ $menu == MenuEnum::SUCHGEBIETE ? 'active' : '' }}}">
				<a href="{{ URL::action('SuchgebieteDesktopController@renderSuchgebiete') }}"><i class="glyphicon glyphicon-tree-conifer"></i> Suchgebiete</a>
			</li>
			<li  class="{{{ $menu == MenuEnum::TERMINE ? 'active' : '' }}}">
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