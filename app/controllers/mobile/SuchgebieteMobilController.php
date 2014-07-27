<?php

class SuchgebieteMobilController extends Controller {

    private $suchgebieteService;

    public function __construct(SuchgebieteService $suchgebieteService) {
        $this->suchgebieteService = $suchgebieteService;
    }

    public function index() 
    {
        $suchgebiete = $this->suchgebieteService->all();

        return View::make('suchgebiete.mobile.uebersicht')
                ->withSuchgebiete($suchgebiete);
    }

    public function details($id)
    {
        $suchgebiet = $this->suchgebieteService->lade($id);

        return View::make('suchgebiete.mobile.details')
                ->withSuchgebiet($suchgebiet);
    }

}