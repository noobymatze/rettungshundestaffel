<?php

class SuchgebieteMobilController extends Controller {

    private $suchgebieteService;

    public function __construct(SuchgebieteService $suchgebieteService) {
        $this->suchgebieteService = $suchgebieteService;
    }

    /**
     * Zeigt eine Übersicht aller Suchgebiete.
     */
    public function index() 
    {
        $suchgebiete = $this->suchgebieteService->all();

        return View::make('suchgebiete.mobile.uebersicht')
                ->withSuchgebiete($suchgebiete)
                ->withMenu(MenuEnum::SUCHGEBIETE);
    }

}