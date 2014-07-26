<?php

/**
 * Kümmert sich um die Mitglieder in der Mobile Variante
 */
class MMitgliederController extends Controller {
	
	public function __construct(MitgliederService $mitgliederService) {
        $this->mitgliederService = $mitgliederService;
    }

    public function renderMitglieder()
    {
        $suchbegriff = Input::get('suchbegriff');

    	$id = Auth::id();
    	$me = $this->mitgliederService->lade($id);

    	$others = $this->mitgliederService->allGroupedExeptForOne($id, $suchbegriff);

        return View::make('mitglieder.mobile.mitglieder')
        	->with('me', $me)
        	->with('others', $others)
            ->with('suchbegriff', $suchbegriff);
    }

    public function renderMitglied($mitglied_id)
    {
        $mitglied = $this->mitgliederService->lade($mitglied_id);

        return View::make('mitglieder.mobile.mitglied')
            ->with('mitglied', $mitglied);
    }
}