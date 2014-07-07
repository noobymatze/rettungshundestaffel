@extends('layouts.desktop')

@section('title')
Details
@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					@if(Auth::user()->id === $mitglied->id || Auth::user()->rolle === "Staffelleitung")
					<button type="button" class="btn btn-warning">Profil bearbeiten</button>
					@endif
					@ifstaffelleitung
						<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" data-toggle="modal" data-target="#modalLoeschen">Profil löschen</a></li>
						</ul>
					@endif
				</div>
				<h3>Eugen Feit</h3>
			</div>
			<ul class="list-group">
				<li class="list-group-item">
					<img class="media-object center-block" src="http://famgroup.ru/avatars/small/missing.png?1345203819" alt="...">
				</li>
				<li class="list-group-item">

				</li>
				<li class="list-group-item">

				</li>
				<li class="list-group-item">

				</li>
				<li class="list-group-item">

				</li>
			</ul>
		</div>
	</div>
</div>

<!-- Modal-Dialog zum Löschen -->
@ifstaffelleitung
<div class="modal fade" id="modalLoeschen">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Benutzer löschen</h4>
			</div>
			<div class="modal-body">
				<p>Wollen Sie sich wirklich Eugen Feit löschen? Alle Benutzerspezifische Daten werden unwiderruflich gelöscht. Diese Aktion kann nicht rückgängig gemacht werden!</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
				<a href="ausloggen" class="btn btn-danger">Löschen</a>
			</div>
		</div>
	</div>
</div>
@endif

@stop