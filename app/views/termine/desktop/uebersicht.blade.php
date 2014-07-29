@extends('layouts.desktop')

@section('content')
<div class="content-header">
    <h1>
        <a href="#"><a id="menu-toggle" href="#" class="btn btn-default"><i class="glyphicon glyphicon-resize-horizontal"></i></a>
            Termine
    </h1>
	@ifstaffelleitung
	<div class="col-md-3 pull-right">
		<a class="btn btn-primary btn-right" href="{{ URL::action('TermineDesktopController@renderErstelleTermin') }}">
			<i class="glyphicon glyphicon-plus"></i> Termin erstellen
		</a>
	</div>
	@endif
</div>
{{ $termine->links() }}

<table class="table table-responsive">
	<thead>
		<tr>
			<th>Datum</th>
			<th>Art</th>
			<th>Beschreibung</th>
			<th>Erstellt von</th>
<!--			<th>Suchgebiet</th>
-->			<th>Adresse</th>
			<th>Aktionen</th>
		</tr>
	</thead>
	<tbody>
		@foreach($termine as $termin)
		<tr>
			<td>{{ date_format(date_create_from_format('Y-m-d H:i:s', $termin->datum), 'd.m.Y - H:i') }}</td>
			<td>{{ $termin->art }}</td>
			<td>{{ $termin->beschreibung }}</td>
			<td>{{ $termin->ersteller->vollerName() }}</td>
			<!--			@if($termin->suchgebiet != null)
						<td>{{ $termin->suchgebiet->name }}</td>
						@else
						<td></td>
						@endif
						-->
			@if($termin->adresse != null)
			<td>{{ $termin->adresse->adresseKurz() }}</td>
			@else
			<td></td>
			@endif
			<td>
				<div class="btn-group">
					<a href="#" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></a>
					<a href="#" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
				</div>
				
				@ifstaffelleitung
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<i class="glyphicon glyphicon-wrench"></i> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ URL::action('TermineDesktopController@renderBearbeiteTermin', [$termin->id]) }}"><i class="glyphicon glyphicon-edit"></i> Bearbeiten</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-minus-sign"></i> Absagen</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-ban-circle"></i> Löschen</a></li>
					</ul>
				</div>
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@stop