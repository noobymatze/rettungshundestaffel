<?php

class HundeDesktopController extends Controller {

    public function __construct(HundeService $hundeService)
    {
        $this->hundeService = $hundeService;
    }

    /**
     * Speichert den Hund als Teil des Mitglieds.
     * 
     * @param string $mitglied_id Die ID des zum Hunde zugehörigen Mitglieds.
     */
    public function speichere($mitglied_id) 
    {
        $mitglied_id = intval($id);
        if (Auth::user()->id !== $mitglied_id) 
        {
            return Redirect::to('/mitglieder');
        }

        $regeln = array('name' => 'required');
        $validator = Validator::make(Input::all(), $regeln);
        if ($validator->fails()) 
        {
            return View::make('mitglieder.desktop.bearbeite-hund')
                    ->withInput(Input::all())
                    ->withErrors($validator);
        }

        $hund = new Hund;
        if (Input::has('hund_id')) 
        {
            $hund = $this->hundeService->lade($id);
        }

        $hund->name = Input::get('name');
        $hund->rasse = 
        $hund->mitglied_id = $mitglied_id;

        return View::make('mitglieder.desktop.details')
                ->with('mitglied', $mitglied);
    }

    /**
     * Rendert das Template erstelle-hund in Mitglieder.
     * 
     * @return Illuminate\View\View Gerendertes erstelle Hund Template.
     */
    public function renderErstelleHund($id) 
    {
        if (Auth::user()->id !== intval($id))
        {
            return Redirect::to('/mitglieder');
        }

        $hund = new Hund;

        return View::make('mitglieder.desktop.bearbeite-hund')
                ->with('mitglied', Auth::user())
                ->with('hund', $hund);
    }

}
