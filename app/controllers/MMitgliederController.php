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
    	$id = Auth::id();
    	$me = $this->mitgliederService->holeMitglied($id);
    	$others = $this->mitgliederService->allExceptFor($id);

        return View::make('mitglieder.mobile.mitglieder')
        	->with('menu', MenuEnum::MITGLIEDER)
        	->with('me', $me)
        	->with('others', $others);
    }
}
