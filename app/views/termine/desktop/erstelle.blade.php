@extends('layouts.desktop')

@section('content')
<div class="content-header">
    <h1>
        <a href="#"><a id="menu-toggle" href="#" class="btn btn-default"><i class="glyphicon glyphicon-resize-horizontal"></i></a>
		@if($termin->id == null)
		Neuen Termin erstellen
		@else
		Termin bearbeiten
		@endif
    </h1>
</div>
<div class="row">
	<div class="col-md-6">
		{{ Form::model($termin, array('action' => 'TermineDesktopController@speichere', 'class' => 'form-horizontal')) }}
		{{ Form::hidden('id') }}
		<section class="form-group @hasError('datum')">
			<label class="col-sm-5 control-label">Datum/Uhrzeit:*</label>
			<div class="col-sm-7">
				<div class='input-group date' id='datetimepicker' data-date-format="DD.MM.YYYY - HH:mm">
					{{ Form::text('datum', date_format($termin->datum, 'd.m.Y - H:i'), array('class' => 'form-control')) }}
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</section>
		<section class="form-group">
			<label class="col-sm-5 control-label">Art:*</label>
			<div class="col-sm-7">
				{{ Form::select('art', array('Allgemein' => 'Allgemein', 'Training' => 'Training'), $termin->art, array('class' => 'form-control')) }}
			</div>
		</section>
		<section class="form-group">
			<label class="col-sm-5 control-label">Beschreibung:</label>
			<div class="col-sm-7">
				{{ Form::textarea('beschreibung', null, array('class' => 'form-control')) }}
			</div>
		</section>
		<section class="form-group">
			<label class="col-sm-5 control-label">Suchgebiet:</label>
			<div class="col-sm-7">
				{{ Form::select('suchgebiet_id', $suchgebieteArray, null, array('class' => 'form-control')) }}
			</div>
		</section>
		<hr>
		<section class="form-group">
			<label class="col-sm-5 control-label">Adresse:</label>
			<div class="col-sm-7 control-label">
				{{ Form::select('adresse_id', $adressenArray, null, array('class' => 'form-control', 'id' => 'adresseAuswahl')) }}
			</div>
		</section>
		<div id="adresse">
			<section class="form-group  @hasError('hausnummer')">
				<label class="col-sm-5 control-label">Straße/Hausnummer/Zusatz:</label>
				<div class="col-sm-3">
					{{ Form::text('strasse', null, array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text('hausnummer', null, array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text('zusatz', null, array('class' => 'form-control')) }}
				</div>
			</section>
			<section class="form-group  @hasError('ort')">
				<label class="col-sm-5 control-label">PLZ/Ort*:</label>
				<div class="col-sm-2">
					{{ Form::text('postleitzahl', null, array('class' => 'form-control')) }}
				</div>
				<div class="col-sm-5">
					{{ Form::text('ort', null, array('class' => 'form-control')) }}
				</div>
			</section>
		</div>
		<hr>

		@if($errors->has())
		<section class="form-group">
			<div class="col-sm-offset-5 col-sm-7">
				<div class="alert alert-danger" role="alert">
					@foreach($errors->all() as $message)
					<p>{{ $message }}</p>
					@endforeach
				</div>
			</div>
		</section>
		@endif

		<section class="form-group">
			<div class="col-sm-offset-5 col-sm-7">
				{{ Form::submit('Termin speichern', array('class' => 'btn btn-primary pull-right')) }}
			</div>
		</section>

		{{ Form::close() }}
	</div>
</div>

<script type="text/javascript">
	window.addEventListener("DOMContentLoaded", function() {
		$(function() {
			// -1 bedeutet, dass "Neue Adresse anlegen..." ausgewählt worden ist
			if($('#adresseAuswahl').val() == -1) {
				$('#adresse').show();
			} else {
				$('#adresse').hide();
			}

			$('#datetimepicker').datetimepicker({
				language: 'de',
				sideBySide: true,
				minuteStepping: 5
			});

			$('#adresseAuswahl').change(function() {
				// -1 bedeutet, dass "Neue Adresse anlegen..." ausgewählt worden ist
				if ($(this).val() == -1) {
					$('#adresse').show();
				} else {
					$('#adresse').hide();
				}
			});
		});
	});
</script>
@stop