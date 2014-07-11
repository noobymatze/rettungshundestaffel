@extends('layouts.desktop')

@section('title')
Hund anlegen
@stop

@section('content')

{{ Form::model($hund, array('action' => ['HundeDesktopController@speichere', $mitglied->id, $hund->id], 'class' => 'form-horizontal col-md-6', 'files' => true)) }}
{{ Form::hidden('id') }}

<section class="form-group @hasError('name')">
    <label class="control-label col-md-5">Name:*</label>
    <span class="col-md-7">
        {{ Form::text('name', null, ['required' => 'true', 'class' => 'form-control']) }}
    </span>
</section>

<section class="form-group @hasError('rasse')">
    <label class="control-label col-md-5">Rasse:</label>
    <span class="col-md-7">
        {{ Form::text('rasse', null, array('class' => 'form-control')) }}
    </span>
</section>

<section class="form-group">
    <label class="control-label col-md-5">Alter:</label>
    <span class="col-md-7">
        {{ Form::text('alter', null, array('class' => 'form-control')) }}
    </span>
</section>

<section class="form-group">
    <label class="control-label col-md-5">Bild:</label>
    <span class="col-md-7">
        {{ Form::file('bild', null, array('class' => 'form-control')) }}
    </span>
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
    <div class="col-md-5"></div>
    <div class="col-md-7">
        <button type="submit" class="btn btn-primary col-md-12">Speichern</button>
    </div>
</section>

{{ Form::close() }}
@stop

