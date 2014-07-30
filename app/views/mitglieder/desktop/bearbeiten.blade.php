@extends('layouts.desktop')

@section('title')
@stop

@section('content')
<div class="content-header">
    <h1>
        <a href="#"><a id="menu-toggle" href="#" class="btn btn-default"><i class="glyphicon glyphicon-resize-horizontal"></i></a>
            Benutzerdaten bearbeiten
    </h1>
</div>
<div class="row">
	<div class="col-md-6">
		{{ Form::model($mitglied, array('action' => array('MitgliederDesktopController@aktualisiere', $mitglied->id), 'class' => 'form-horizontal', 'files' => true, 'autocomplete' => 'off')) }}
		<section class="form-group">
			<div class="col-sm-7 col-sm-offset-5">
				<img class="media-object center-block img-responsive img-thumbnail" id="bildPreview" src="{{ $mitglied->profilbild() }}" alt="...">
			</div>
		</section>
		<section class="form-group">
			<label class="col-sm-5 control-label">Bild:</label>
			<div class="col-sm-7">
				{{ Form::file('profilbild', ['id' => 'bild', 'accept' => 'image/*']) }}
			</div>
		</section>
        <script src="{{ URL::asset('javascripts/image-change.js') }}"></script>
		<section class="form-group">
			<label class="col-sm-5 control-label">Rolle:</label>
			<div class="col-sm-7">
				@ifstaffelleitung
				<fieldset>
					@else
					<fieldset disabled>
						@endif
						{{ Form::select('rolle', array('Mitglied' => 'Mitglied', 'Staffelleitung' => 'Staffelleitung'), $mitglied->rolle, array('class' => 'form-control')) }}
					</fieldset>
			</div>
		</section>
		<section class="form-group">
			<label class="col-sm-5 control-label">Vorname:</label>
			<div class="col-sm-7">
				{{ Form::text('vorname', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
			</div>
		</section>

		<section class="form-group">
			<label class="col-sm-5 control-label">Nachname:</label>
			<div class="col-sm-7">
				{{ Form::text('nachname', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
			</div>
		</section>

		<section class="form-group @hasError('email')">
			<label class="col-sm-5 control-label">E-Mail:*</label>
			<div class="col-sm-7">
				{{ Form::text('email', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
			</div>
		</section>

		<section class="form-group">
			<label class="col-sm-5 control-label">Telefon:</label>
			<div class="col-sm-7">
				{{ Form::text('telefon', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
			</div>
		</section>

		<section class="form-group">
			<label class="col-sm-5 control-label">Mobil:</label>
			<div class="col-sm-7">
				{{ Form::text('mobil', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
			</div>
		</section>

		<hr>
		<section class="form-group">
			<div class="col-sm-7 col-sm-offset-5">
				<div class="alert alert-info"><small>Geben Sie das Passwort nur ein, wenn Sie es ändern wollen. Ansonsten lassen Sie die Felder leer.</small></div>
			</div>
		</section>
		<section class="form-group @hasError('passwort')">
			<label class="col-sm-5 control-label">Passwort:</label>
			<div class="col-sm-7">
				{{ Form::password('passwort', array('class' => 'form-control', 'autocomplete' => 'off')) }}
			</div>
		</section>
		<section class="form-group @hasError('passwort2')">
			<label class="col-sm-5 control-label">Passwort wiederholen:</label>
			<div class="col-sm-7">
				{{ Form::password('passwort2', array('class' => 'form-control', 'autocomplete' => 'off')) }}
			</div>
		</section>
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
				{{ Form::submit('Speichern', array('class' => 'btn btn-primary pull-right')) }}
			</div>
		</section>


		{{ Form::close() }}
	</div>
</div>
@stop
