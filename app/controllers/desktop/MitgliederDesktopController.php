<?php

/**
 * Kümmert sich um alle Mitglieder in der desktop variante der 
 * Anwendung.
 */
class MitgliederDesktopController extends Controller {

    public function __construct(MitgliederService $mitgliederService) 
    {
        $this->mitgliederService = $mitgliederService;
    }

    /**
     * Stellt die Heimseite dar.
     *
     * @return {View} 
     */
    public function uebersicht() 
    {
        return View::make('mitglieder.desktop.uebersicht')
            ->with('title', 'Mitglieder')
            ->with('mitglieder', $this->mitgliederService->all());
    }
}
