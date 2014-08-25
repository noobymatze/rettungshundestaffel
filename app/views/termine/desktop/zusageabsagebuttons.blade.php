@if($termin->aktiv)
	@if($termin->mitgliedStatus(Auth::user()) == 'Zugesagt')
		<div class="btn-group">
			<a href="#" class="btn btn-default disabled"><i class="glyphicon glyphicon-ok"></i></a>
			<a href="{{ URL::action('TermineDesktopController@absage', [$termin->id]) }}" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
	@elseif($termin->mitgliedStatus(Auth::user()) == 'Abgesagt')
		<div class="btn-group">
			<a href="{{ URL::action('TermineDesktopController@zusage', [$termin->id]) }}" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></a>
			<a href="#" class="btn btn-default disabled"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
	@else
		<div class="btn-group">
			<a href="{{ URL::action('TermineDesktopController@zusage', [$termin->id]) }}" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></a>
			<a href="{{ URL::action('TermineDesktopController@absage', [$termin->id]) }}" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
	@endif
@else
<div class="btn-group">
	<a href="#" class="btn btn-default disabled"><i class="glyphicon glyphicon-ok"></i></a>
	<a href="#" class="btn btn-default disabled"><i class="glyphicon glyphicon-remove"></i></a>
</div>
@endif