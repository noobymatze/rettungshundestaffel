@extends('layouts.desktop')

@section('title')
Neues Mitglied anlegen
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<p>Bitte geben Sie die Daten des neuen Benutzers ein.</p>
	</div>
	<div class="col-md-6">
		{{ Form::model($mitglied, array('action' => 'MitgliederDesktopController@erstelleMitglied', 'class' => 'form-horizontal')) }}

		<section class="form-group">
			<label class="col-sm-5 control-label">Rolle:*</label>
			<div class="col-sm-7">
				{{ Form::select('rolle', array('Mitglied' => 'Mitglied', 'Staffelleitung' => 'Staffelleitung'), 'Mitglied', array('class' => 'form-control')) }}
			</div>
		</section>
		
		<section class="form-group">
			<label class="col-sm-5 control-label">Vorname:</label>
			<div class="col-sm-7">
				{{ Form::text('vorname', null, array('class' => 'form-control')) }}
			</div>
		</section>
		
		<section class="form-group">
			<label class="col-sm-5 control-label">Nachname:</label>
			<div class="col-sm-7">
				{{ Form::text('nachname', null, array('class' => 'form-control')) }}
			</div>
		</section>

		<section class="form-group @hasError('email')">
			<label class="col-sm-5 control-label">E-Mail:*</label>
			<div class="col-sm-7">
				{{ Form::text('email', null, array('class' => 'form-control')) }}
			</div>
		</section>
		<section class="form-group @hasError('passwort')">
			<label class="col-sm-5 control-label">Passwort:*</label>
			<div class="col-sm-7">
				{{ Form::password('passwort', array('class' => 'form-control')) }}
			</div>
		</section>
		<section class="form-group @hasError('passwort2')">
			<label class="col-sm-5 control-label">Passwort wiederholen:*</label>
			<div class="col-sm-7">
				{{ Form::password('passwort2', array('class' => 'form-control')) }}
			</div>
		</section>

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
				{{ Form::submit('Anlegen', array('class' => 'btn btn-primary pull-right')) }}
			</div>
		</section>
		{{ Form::close() }}
	</div>
</div>
@stop