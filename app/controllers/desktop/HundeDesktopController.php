<?php

class HundeDesktopController extends Controller {

    public function __construct(MitgliederService $mitgliederService, HundeService $hundeService)
    {
        $this->hundeService = $hundeService;
        $this->mitgliederService = $mitgliederService;

        $this->beforeFilter('@filtereAuthentifiziertIstNichtMitglied');
    }

    /**
     * Speichert den Hund als Teil des Mitglieds.
     * 
     * @param string $mitglied_id Die ID des zum Hunde zugehörigen Mitglieds.
     * @param string $hund_id Optionale ID des Hundes, der bearbeitet werden soll.
     */
    public function speichere($mitglied_id, $hund_id = null) 
    {
        $mitglied_id = intval($mitglied_id);

        $regeln = array('name' => 'required', 'alter' => 'numeric');
        $validator = Validator::make(Input::all(), $regeln);

        if ($validator->fails()) 
        {
            return View::make('mitglieder.desktop.bearbeite-hund')
                    ->withInput(Input::all())
                    ->withErrors($validator);
        }

        $hund = new Hund;
        if (isset($hund_id)) 
        {
            $hund = $this->hundeService->lade($hund_id);
        }

        $hund->name = Input::get('name');
        $hund->rasse = Input::get('rasse');
        $hund->alter = Input::get('alter');
        $hund->bild = Input::get('bild');
        $hund->mitglied_id = $mitglied_id;

        $this->hundeService->speichere($hund);

        return View::make('mitglieder.desktop.details')
                ->with('mitglied', $this->mitgliederService->lade($mitglied_id));
    }

    /**
     * Rendert das Template erstelle-hund in Mitglieder.
     * 
     * @param string $mitglied_id Die ID des Mitglieds, für das ein Hund bearbeitet werden soll.
     * @param string|null $hund_id Die Hunde ID oder null, wenn ein neuer Hund gelegt 
     * werden soll.
     * 
     * @return Response Gerendertes erstelle Hund Template.
     */
    public function renderBearbeiten($mitglied_id, $hund_id = null)
    {
        $hund = new Hund;
        if (isset($hund_id)) 
        {
            $hund = $this->hundeService->lade(intval($hund_id));
        }

        $mitglied = Auth::user();
        return View::make('mitglieder.desktop.bearbeite-hund')
                ->with('mitglied', $mitglied)
                ->with('hund', $hund);
    }

    /**
     * Prüft, ob das angemeldete Mitglied auch dem Mitglied im Parameter 
     * entspricht. Ansonsten sollen diese Routen gar nicht zugänglich sein.
     * 
     * @param Route $route 
     * @return Response|void Wird auf /mitglieder redirected.
     */
    public function filtereAuthentifiziertIstNichtMitglied($route) 
    {
        $mitglied_id = intval($route->getParameter('mitglied_id'));
        if (Auth::user()->id !== $mitglied_id) 
        {
            return Redirect::action('MitgliederDesktopController@uebersicht');
        }
    }
}
