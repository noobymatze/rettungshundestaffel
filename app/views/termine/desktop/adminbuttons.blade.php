@ifstaffelleitung
<div class="btn-group">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		<i class="glyphicon glyphicon-wrench"></i> <span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="{{ URL::action('TermineDesktopController@renderBearbeiteTermin', [$termin->id]) }}"><i class="glyphicon glyphicon-edit"></i> Bearbeiten</a></li>
		@if($termin->aktiv)
		<li><a href="{{ URL::action('TermineDesktopController@deaktiviereTermin', [$termin->id]) }}"><i class="glyphicon glyphicon-minus-sign"></i> Absagen</a></li>
		@else
		<li><a href="{{ URL::action('TermineDesktopController@aktiviereTermin', [$termin->id]) }}"><i class="glyphicon glyphicon-ok-sign"></i> Termin wieder aktivieren</a></li>
		@endif
	</ul>
</div>
@endif