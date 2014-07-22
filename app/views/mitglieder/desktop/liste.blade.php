@for ($i = 0; $i < $mitglieder->count(); $i+=3) 
<section class="row">
    @foreach($mitglieder->slice($i, 3) as $mitglied) 
    <section class="media mitglied col-md-4">
        <img class="pull-left col-md-4 media-object" src="{{ $mitglied->profilbild() }}"/>
        <section class="media-body">
            <h3 class="media-heading">{{ $mitglied->vollerName() }}</h3>
            <span class="row col-md-12">{{ $mitglied->email }}</span>
            <span class="row col-md-12"><span class="glyphicon glyphicon-earphone"></span> {{ $mitglied->telefon }}</span>
            <a href="{{ URL::action('MitgliederDesktopController@renderMitglied', [$mitglied->id]) }}" class="btn btn-primary">Anschauen</a>
        </section>
    </section>
    @endforeach
</section>
@endfor

{{ $mitglieder->links() }}
