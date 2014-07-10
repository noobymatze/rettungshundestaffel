@extends('layouts.desktop')

@section('title')
@stop

@section('content')

{{ Form::model($hund, array( 'action' => 'MitgliederDesktopController@speichereHund', 'class' => 'form-horizontal col-md-6')) }}
{{ Form::hidden('id') }}

<section class="form-group">
    <label class="control-label col-md-5 @hasError('name') has-feedback">Name:*</label>
    <span class="col-md-7">
        {{ Form::text('name', null, array('class' => 'form-control')) }}
        {{ Form::feedback($errors->has('name')) }}
    </span>
</section>



{{ Form::close() }}
@stop

