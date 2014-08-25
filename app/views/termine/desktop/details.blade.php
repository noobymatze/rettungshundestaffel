@extends('layouts.desktop')

@section('content')
<div class="content-header">
	<a href="#"><a id="menu-toggle" href="#" class="btn btn-default"><i class="glyphicon glyphicon-resize-horizontal"></i></a>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<span class="col-md-4 text-right"><strong>Fällig am:</strong></span>
					<span class="col-md-8">{{ date_format(date_create_from_format('Y-m-d H:i:s', $termin->datum), 'd.m.Y - H:i') }}</span>
				</div>
			</div>
			<ul class="list-group">
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Art:</strong></span>
						<span class="col-md-8">{{ $termin->art }}</span>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Beschreibung:</strong></span>
						<span class="col-md-8">{{ preg_replace("/\r\n|\r|\n/",'<br>', $termin->beschreibung) }}</span>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Suchgebiet:</strong></span>
						@if($termin->suchgebiet != null)
						<span class="col-md-8">
							<a href="{{ URL::action('SuchgebieteDesktopController@renderSuchgebiet', ['id' => $termin->suchgebiet->id, 'name' => Str::slug($termin->suchgebiet->name, '_')]) }}">
								{{ $termin->suchgebiet->name }}
							</a>
						</span>
						@endif
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Adresse:</strong></span>
						<span class="col-md-8">
							<adress>
								@if($termin->adresse != null)
								{{ $termin->adresse->postleitzahl }} {{ $termin->adresse->ort }}<br>
								{{ $termin->adresse->strasse }} {{ $termin->adresse->hausnummer }} {{ $termin->adresse->zusatz }}<br>
								@endif
							</adress>
						</span>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Erstellt am:</strong></span>
						<span class="col-md-8">{{ date_format(date_create_from_format('Y-m-d H:i:s', $termin->created_at), 'd.m.Y - H:i') }}</span>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Zuletzt geändert am:</strong></span>
						<span class="col-md-8">{{ date_format(date_create_from_format('Y-m-d H:i:s', $termin->updated_at), 'd.m.Y - H:i') }}</span>
					</div>
				</li>
				<li class="list-group-item list-group-item-success">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Zugesagt:</strong></span>
						<span class="col-md-8">
							<ul class="list-unstyled">
								@foreach($termin->mitgliederZugesagt() as $mitglied)
								<li><a href="{{ URL::action('MitgliederDesktopController@renderMitglied', [$mitglied->id]) }}">{{ $mitglied->vollerName() }}</a></li>
								@endforeach
							</ul>
						</span>
					</div>
				</li>
				<li class="list-group-item list-group-item-danger">
					<div class="row">
						<span class="col-md-4 text-right"><strong>Abgesagt:</strong></span>
						<span class="col-md-8">
							<ul class="list-unstyled">
								@foreach($termin->mitgliederAbgesagt() as $mitglied)
								<li><a href="{{ URL::action('MitgliederDesktopController@renderMitglied', [$mitglied->id]) }}">{{ $mitglied->vollerName() }}</a></li>
								@endforeach
							</ul>
						</span>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

@stop