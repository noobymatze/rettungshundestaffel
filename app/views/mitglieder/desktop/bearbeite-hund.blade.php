@extends('layouts.desktop')

@section('title')
@stop

@section('content')

{{ Form::model($hund, array('action' => ['HundeDesktopController@speichere', $mitglied->id], 'class' => 'form-horizontal col-md-6', 'files' => true)) }}
{{ Form::hidden('id') }}

<section class="form-group">
    <label class="control-label col-md-5 @hasError('profilbild') has-feedback">Bild:</label>
    <span class="col-md-7">
        {{ Form::file('profilbild', null, array('class' => 'form-control')) }}
        {{ Form::feedback($errors->has('profilbild')) }}
    </span>
</section>

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
    <label class="control-label col-md-5 @hasError('name') has-feedback">Name:*</label>
    <span class="col-md-7">
        {{ Form::text('', null, array('class' => 'form-control')) }}
        {{ Form::feedback($errors->has('name')) }}
    </span>
</section>

<section class="form-group">
    <label class="control-label col-md-5 @hasError('name') has-feedback">Name:*</label>
    <span class="col-md-7">
        {{ Form::text('name', null, array('class' => 'form-control')) }}
        {{ Form::feedback($errors->has('name')) }}
    </span>
</section>

{{ Form::close() }}
@stop

