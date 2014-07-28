<?php

/**
 * Kümmert sich um das "Weiteres"-Menü in der Mobile Variante
 * Macht u.a. den Logout
 */
class MWeiteresController extends Controller {
	
	public function __construct(MitgliederService $mitgliederService) {
        $this->mitgliederService = $mitgliederService;
    }

    public function renderWeiteres()
    {
         return View::make('weiteres');
    }
}
