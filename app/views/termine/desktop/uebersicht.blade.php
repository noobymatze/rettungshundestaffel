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
		{{ Form::open(['class' => 'form-horizontal', 'action' => 'TermineDesktopController@uebersicht', 'method' => 'get', 'id' => 'datumForm']) }}
		<section class="form-group">
			<label class="col-sm-6 control-label">Termine anzeigen ab:</label>
			<div class="col-sm-6">
				<div class='input-group date' id='datetimepicker' data-date-format="DD.MM.YYYY">
					{{ Form::text('datum', $datum, ['class' => 'form-control', 'id' => 'eingabe']) }}
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</section>
		{{ Form::close() }}
	</div>
</div>
<hr>
<table class="table table-responsive">
	<thead>
		<tr>
			<th>Datum</th>
			<th>Art</th>
			<th>Beschreibung</th>
			<th>Erstellt von</th>
			<th>Suchgebiet</th>
			<th>Adresse</th>
			<th>Aktionen</th>
		</tr>
	</thead>
	<tbody>
		@foreach($termine as $termin)
		
		@if($termin->aktiv)
			@if($termin->mitgliedStatus(Auth::user()) == 'Zugesagt')
				<tr class="success">
			@elseif($termin->mitgliedStatus(Auth::user()) == 'Abgesagt')
				<tr class="danger">
			@else
				<tr class="active">
			@endif
		@else
		<tr>
		@endif
			<td><a href="{{ URL::action('TermineDesktopController@renderDetailansicht', [$termin->id]) }}">{{ date_format(date_create_from_format('Y-m-d H:i:s', $termin->datum), 'd.m.Y - H:i') }}</a></td>
			<td>
				@if($termin->art == 'Allgemein')
					<span class="label label-info">A</span>
				@else
					<span class="label label-success">T</span>
				@endif
			</td>
			<td>{{ $termin->kurzeBeschreibung() }}</td>
			<td>{{ $termin->ersteller->vollerName() }}</td>
			@if($termin->suchgebiet != null)
			<td>{{ $termin->suchgebiet->name }}</td>
			@else
			<td></td>
			@endif
			<td>
				@if($termin->adresse != null)
				{{ $termin->adresse->adresseKurz() }}
				@endif
			</td>
			<td>
				@include('termine.desktop.zusageabsagebuttons', ['termin' => $termin])
				@include('termine.desktop.adminbuttons', ['termin' => $termin])
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