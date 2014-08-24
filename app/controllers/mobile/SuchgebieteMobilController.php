<?php

class SuchgebieteMobilController extends Controller {

    private $suchgebieteService;
    private $osmService;

    public function __construct(SuchgebieteService $suchgebieteService, OSMSearchService $osmService) {
        $this->suchgebieteService = $suchgebieteService;
        $this->osmService = $osmService;
    }

    public function index() 
    {
        $suchgebiete = $this->suchgebieteService->all();
        $flaechen = $suchgebiete->map(function($suchgebiet) {
            return $this->suchgebieteService->ladeFlaechenAsGeoJson($suchgebiet);
        });

        return View::make('suchgebiete.mobile.uebersicht')
                ->withFlaechen($flaechen)
                ->withSuchgebiete($suchgebiete);
    }

    public function details($id)
    {
        $suchgebiet = $this->suchgebieteService->lade($id);
        $flaechen = $this->suchgebieteService->ladeFlaechenAsGeoJson($suchgebiet);
        $treffpunkt = null;
        try {
            $treffpunkt = $this->osmService->findeLatUndLong($suchgebiet->adresse);
        } catch (Exception $ex) {
        }

        return View::make('suchgebiete.mobile.details')
                ->withTreffpunkt($treffpunkt)
                ->withFlaechen($flaechen)
                ->withSuchgebiet($suchgebiet);
    }

}