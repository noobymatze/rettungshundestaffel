<?php

/**
 * Kümmert sich um alle Mitglieder in der desktop variante der 
 * Anwendung.
 */
class MitgliederController extends Controller {

    public function __construct(MitgliederService $mitgliederService) 
    {
        $this->mitgliederService = $mitgliederService;
    }

    /**
     * Stellt die Heimseite dar.
     *
     * @return {View} 
     */
    public function home() 
    {
        return View::make('home')
            ->with('title', 'Test')
            ->with('mitglieder', $mitgliederService->all())
    }
}
