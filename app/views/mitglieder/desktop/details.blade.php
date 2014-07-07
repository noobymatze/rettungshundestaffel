@extends('layouts.desktop')

@section('title')
@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<h1>
			Benutzer
			<div class="btn-group pull-right">
				<!-- Überprüfen, ob es sich um mein Profil handelt, oder ich der Admin bin -->
				@if(Auth::user()->id === $mitglied->id || Auth::user()->rolle === "Staffelleitung")
				<button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Profil bearbeiten</button>
				@endif
				@ifstaffelleitung
				<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" data-toggle="modal" data-target="#modalLoeschen"><span class="glyphicon glyphicon-remove"></span> Profil löschen</a></li>
				</ul>
				@endif
			</div>
		</h1>
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-heading">
					<h3 class="panel-title">{{ $mitglied->vorname . " " . $mitglied->nachname }}</h3>
				</div>
			</div>
			<ul class="list-group">
				<li class="list-group-item">
					<img class="media-object center-block img-responsive img-thumbnail" src="http://famgroup.ru/avatars/small/missing.png?1345203819" alt="...">
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4">Rolle:</span><span class="col-md-8"><span class="glyphicon glyphicon-user"></span> {{ $mitglied->rolle }}</span>
					</div>
				</li>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4">Telefon:</span><span class="col-md-8"><span class="glyphicon glyphicon-earphone"></span> {{ $mitglied->telefon }}</span>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4">Mobil:</span><span class="col-md-8"><span class="glyphicon glyphicon-phone"></span> {{ $mitglied->mobil }}</span>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

<!-- Hunde -->
<div class="row">
	<div class="col-md-6">
		<h1>
			Hunde
			<!-- Überprüfen, ob es sich um mein Profil handelt, oder ich der Admin bin -->
			@if(Auth::user()->id === $mitglied->id || Auth::user()->rolle === "Staffelleitung")
			<a href="#" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Hund hinzufügen</a>
			@endif
		</h1>
		<!-- Falls der Benutzer keine Hunde hat -->
		@if($mitglied->hunde->count() <= 1)
		<div class="alert alert-info" role="alert">Der Benutzer hat noch keine Hunde hinzugefügt.</div>
		@endif
	</div>
</div>

<!-- Hunde -->
@foreach($mitglied->hunde as $hund)
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-heading">
					<h3 class="panel-title">{{ $hund->name }}</h3>
				</div>
			</div>
			<ul class="list-group">
				<li class="list-group-item">
					<img class="media-object center-block img-responsive img-thumbnail" src="http://avatarmaker.net/free-avatars/avatars/animals_216/dogs_238/cute_brown_dog_avatar_100x100_31524.jpg" alt="...">
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4">Rasse:</span>{{ $hund->rasse }}</span>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4">Alter:</span>{{ $hund->alter }}</span>
					</div>
				</li>
				<li class="list-group-item">
					<div class="panel panel-info">
						<div class="panel-heading">Sucharten</div>
						<ul class="list-group">
							@foreach($hund->sucharten as $suchart)
							<li class="list-group-item">
								{{ $suchart->name }}
							</li>
							@endforeach
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
@endforeach

<!-- Modal-Dialog zum Löschen von Benutzer -->
@ifstaffelleitung
<div class="modal fade" id="modalLoeschen">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Benutzer löschen</h4>
			</div>
			<div class="modal-body">
				<p>Wollen Sie sich wirklich <span class="bg-primary">{{ $mitglied->vorname . " " . $mitglied->nachname }}</span> löschen? Alle Benutzerspezifische Daten werden unwiderruflich gelöscht. Diese Aktion kann nicht rückgängig gemacht werden!</p>
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