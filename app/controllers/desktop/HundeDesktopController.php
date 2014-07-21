<?php

class HundeDesktopController extends Controller {

    public function __construct(MitgliederService $mitgliederService, HundeService $hundeService, SuchartenService $suchartenService)
    {
        $this->hundeService = $hundeService;
        $this->mitgliederService = $mitgliederService;
        $this->suchartenService = $suchartenService;

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
        $datums_format = 'd.m.Y';
        $sucharten_liste = $this->suchartenService->holeAlle();

        // Regeln werden dynamisch in der Form: 'Flaechensuche_bis' => 'date_format:dd.mm.YYYY'
        // zusammengebaut.
        $regeln = [];
        $regeln['name'] = 'required';
        $regeln['alter'] = 'numeric';
        $regeln['bild'] = 'mimes:png,jpg,jpeg,gif';

        foreach($sucharten_liste->toArray() as $suchart) {
            $regeln[$suchart['name'] . '_bis'] = 'date_format:' . $datums_format;
        }

        $mitglied_id = intval($mitglied_id);
        $validator = Validator::make(Input::all(), $regeln);
        if ($validator->fails()) 
        {
            return Redirect::back()
                    ->withInput(Input::all())
                    ->withErrors($validator);
        }

        $hund = new Hund;
        if (isset($hund_id)) 
        {
            $hund = $this->hundeService->lade($hund_id);
        }

        // Default Einstellungen:
        $hund->name = Input::get('name');
        $hund->rasse = Input::get('rasse');
        $hund->mitglied_id = $mitglied_id;

        if(Input::has('alter')) 
        {
            $hund->alter = Input::get('alter');
        }

        if (Input::hasFile('bild')) 
        {
            $hund->bild = File::get(Input::file('bild')->getRealPath());
        }

        // Sucharten:
        $sucharten = $sucharten_liste->filter(function ($suchart) { 
            return Input::has($suchart->name); 
        });

        $this->hundeService->speichere($hund);
        $hund->sucharten()->sync($sucharten);

        foreach($hund->sucharten as $suchart) {
            $suchart->pivot->geprueft_bis = DateTime::createFromFormat("d.m.Y", Input::get($suchart->name . '_bis'));
            $suchart->pivot->save();
        }

        return Redirect::action('MitgliederDesktopController@renderMitglied', [$mitglied_id]);
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

        $sucharten = $this->suchartenService->holeAlle();
        $mitglied = Auth::user();
        return View::make('mitglieder.desktop.bearbeite-hund')
                ->with('sucharten', $sucharten)
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
        if (Auth::user()->id != $mitglied_id) 
        {
            return Redirect::action('MitgliederDesktopController@uebersicht');
        }
    }

    /**
     * Loescht einen Hund aus der Datenbank und leitet zurück auf die Mitliederseite.
     * 
     * @param string $hund_id
     */
    public function loesche($mitglied_id, $hund_id) 
    {
        $this->hundeService->loesche(intval($hund_id));

        return Redirect::action('MitgliederDesktopController@renderMitglied', [$mitglied_id]);
    }
}
