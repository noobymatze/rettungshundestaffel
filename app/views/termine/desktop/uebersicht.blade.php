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

<div class="row">
	<div class="col-md-6">
		<form class="form-horizontal" id="datumForm" action="#" method="GET">
			<section class="form-group">
				<label class="col-sm-6 control-label">Termine anzeigen ab:</label>
				<div class="col-sm-6">
					<div class='input-group date' id='datetimepicker' data-date-format="DD.MM.YYYY">
						<input type="text" class="form-control" id="eingabe">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</section>
		</form>
	</div>
</div>
<hr>
<table class="table table-responsive">
	<thead>
		<tr>
			<th>Datum</th>
			<!--<th>Art</th>-->
			<th>Beschreibung</th>
			<th>Erstellt von</th>
<!--			<th>Suchgebiet</th>
			-->			<th>Adresse</th>
			<th>Aktionen</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($termine as $termin)
		@if($termin->aktiv)
		<tr class="active">
		@else
		<tr>
		@endif
			<td><a href="{{ URL::action('TermineDesktopController@renderDetailansicht', [$termin->id]) }}">{{ date_format(date_create_from_format('Y-m-d H:i:s', $termin->datum), 'd.m.Y - H:i') }}</a></td>
			<!--<td>{{ $termin->art }}</td>-->
			<td>{{ $termin->beschreibung }}</td>
			<td>{{ $termin->ersteller->vollerName() }}</td>
			<!--			@if($termin->suchgebiet != null)
						<td>{{ $termin->suchgebiet->name }}</td>
						@else
						<td></td>
						@endif
			-->
			<td>
				@if($termin->adresse != null)
				{{ $termin->adresse->adresseKurz() }}
				@endif
			</td>
			<td>
				@if($termin->aktiv)
				<div class="btn-group">
					<a href="{{ URL::action('TermineDesktopController@zusage', [$termin->id]) }}" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></a>
					<a href="{{ URL::action('TermineDesktopController@absage', [$termin->id]) }}" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
				</div>
				@else
				<div class="btn-group">
					<a href="#" class="btn btn-default disabled"><i class="glyphicon glyphicon-ok"></i></a>
					<a href="#" class="btn btn-default disabled"><i class="glyphicon glyphicon-remove"></i></a>
				</div>
				@endif

				@ifstaffelleitung
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<i class="glyphicon glyphicon-wrench"></i> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ URL::action('TermineDesktopController@renderBearbeiteTermin', [$termin->id]) }}"><i class="glyphicon glyphicon-edit"></i> Bearbeiten</a></li>
						@if($termin->aktiv)
						<li><a href="{{ URL::action('TermineDesktopController@deaktiviereTermin', [$termin->id]) }}"><i class="glyphicon glyphicon-minus-sign"></i> Absagen</a></li>
						@else
						<li><a href="{{ URL::action('TermineDesktopController@aktiviereTermin', [$termin->id]) }}"><i class="glyphicon glyphicon-ok-sign"></i> Termin wieder aktivieren</a></li>
						@endif
					</ul>
				</div>
				@endif
			</td>
			<td>
<!--				{{ $termin->mitgliederAbgesagt() }}-->
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{{ $termine->appends(Input::all())->links() }}

<script type="text/javascript">
	window.addEventListener("DOMContentLoaded", function() {
		$(function() {
			var dp = $('#datetimepicker').datetimepicker({
				language: 'de',
				pickTime: false
			});

			dp.change(function() {
				$('#datumForm').submit();
			});
		});
	});
</script>

@stop