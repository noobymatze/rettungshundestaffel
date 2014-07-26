<?php

/**
 * Kümmert sich um das Dashboard in der Mobile Variante
 */
class MDashboardController extends Controller {
	
    public function renderDashboard() 
    {
        return View::make('dashboard.mobile.dashboard');
    }
}
