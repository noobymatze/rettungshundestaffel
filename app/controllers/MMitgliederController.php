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
    	$me = $this->mitgliederService->holeMitglied($id);

    	$others = $this->mitgliederService->allGroupedExeptForOne($id, $suchbegriff);

        return View::make('mitglieder.mobile.mitglieder')
        	->with('menu', MenuEnum::MITGLIEDER)
        	->with('me', $me)
        	->with('others', $others)
            ->with('suchbegriff', $suchbegriff);
    }

    public function renderMitglied($mitglied_id)
    {
        $mitglied = $this->mitgliederService->holeMitglied($mitglied_id);

        return View::make('mitglieder.mobile.mitglied')
            ->with('menu', MenuEnum::MITGLIEDER)
            ->with('mitglied', $mitglied);
    }
}