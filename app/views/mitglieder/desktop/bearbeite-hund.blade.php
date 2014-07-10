@extends('layouts.desktop')

@section('title')
Hund anlegen
@stop

@section('content')

{{ Form::model($hund, array('action' => ['HundeDesktopController@speichere', $mitglied->id], 'class' => 'form-horizontal col-md-6', 'files' => true)) }}
{{ Form::hidden('id') }}

<section class="form-group">
    <label class="control-label col-md-5 @hasError('name') has-feedback">Name:*</label>
    <span class="col-md-7">
        {{ Form::text('name', null, array('class' => 'form-control')) }}
        {{ Form::feedback($errors->has('name')) }}
    </span>
</section>

<section class="form-group">
    <label class="control-label col-md-5 @hasError('rasse') has-feedback">Rasse:</label>
    <span class="col-md-7">
        {{ Form::text('rasse', null, array('class' => 'form-control')) }}
        {{ Form::feedback($errors->has('name')) }}
    </span>
</section>

<section class="form-group">
    <label class="control-label col-md-5 @hasError('alter') has-feedback">Alter:</label>
    <span class="col-md-7">
        {{ Form::text('alter', null, array('class' => 'form-control')) }}
        {{ Form::feedback($errors->has('alter')) }}
    </span>
</section>

<section class="form-group">
    <label class="control-label col-md-5 @hasError('bild') has-feedback">Bild:</label>
    <span class="col-md-7">
        <span class="btn btn-primary btn-file">
            Suche Bild {{ Form::file('bild', null, array('class' => 'form-control')) }}
        </span>
    </span>
</section>

<section class="form-group">
    <div class="col-md-5"></div>
    <div class="col-md-7">
        <button type="submit" class="btn btn-primary col-md-12">Speichern</button>
    </div>
</section>

{{ Form::close() }}
@stop

