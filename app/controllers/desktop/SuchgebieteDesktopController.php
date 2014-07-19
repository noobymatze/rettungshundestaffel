<?php

/**
 * Kümmert sich um die Suchgebiete in der desktop variante der 
 * Anwendung.
 */
class SuchgebieteDesktopController extends Controller {

	public function __construct(SuchgebieteService $suchgebieteService)
	{
		$this->suchgebieteService = $suchgebieteService;
	}

	/**
	 * Stellt die Heimseite dar.
	 *
	 * @return {View} 
	 */
	public function renderSuchgebiete()
	{
		return View::make('suchgebiete.desktop.uebersicht')
						->with('suchbegriff', null)
						->with('suchgebiete', $this->suchgebieteService->all())
						->with('menu', MenuEnum::SUCHGEBIETE);
	}
}
