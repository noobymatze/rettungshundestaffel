@extends('layouts.desktop')

@section('content')
<div class="content-header">
    <h1>
        <a href="#"><a id="menu-toggle" href="#" class="btn btn-default"><i class="glyphicon glyphicon-resize-horizontal"></i></a>
            Hund anlegen
    </h1>
</div>

{{ Form::model($hund, array('action' => ['HundeDesktopController@speichere', $mitglied->id, $hund->id], 'class' => 'form-horizontal col-md-6', 'files' => true)) }}
{{ Form::hidden('id') }}

<section class="form-group">
    <div class="col-sm-7 col-sm-offset-5">
        <img class="media-object center-block img-responsive img-thumbnail" id="bildPreview" src="{{ $hund->bild() }}" alt="...">
    </div>
</section>

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
        {{ Form::file('bild', ['id' => 'bild', 'accept' => 'image/*']) }}
    </span>
</section>
<script src="{{ URL::asset('javascripts/image-change.js') }}"></script>


<hr>
@foreach($sucharten as $suchart)
<section class="form-group">
    <label class="control-label col-md-5">{{ $suchart->name }}: </label>
    <span class="col-md-1">
        {{ Form::checkbox($suchart->name, $suchart->name, $hund->sucharten->contains($suchart), ['class' => 'checkbox-bottom']) }}
    </span>
    <div class="col-md-5 input-group">
        {{ Form::text($suchart->name . '_bis', 
                        $hund->getSuchartGeprueftBis($suchart->id), 
                        ['class' => 'form-control', 'placeholder' => 'Format: dd.mm.jjjj']) }}
        <span class="glyphicon glyphicon-calendar input-group-addon"></span>
    </div>
</section>
@endforeach

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

