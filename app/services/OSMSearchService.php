<?php

/**
 * Diese Klasse kapselt die suchen via 
 * OSM search.
 */
class OSMSearchService {

    private $client;

    public function __construct() {
        $this->client = new \GuzzleHttp\Client([
            'base_url' => "http://nominatim.openstreetmap.org"
        ]);
    }

    /**
     * 
     * @param Adresse $adresse
     * @throws Exception Wirft eine Fehlermeldung, wenn der 
     * eigentliche Call fehlgeschlagen ist, aber auch, wenn semantisch
     * etwas nicht korrekt gewesen ist.
     */
    public function findeLatUndLong(Adresse $adresse) {
        $response = $this->client->get('/search', [
            'query' => [
                'street' => $adresse->hausnummer.' '.$adresse->strasse,
                'city' => $adresse->ort,
                'country' => 'Germany',
                'format' => 'json'
            ]
        ])->json();

        if(count($response) == 0) {
            throw new Exception("Die Adresse konnte nicht gefunden werden.");
        }

        return [
            'latitude' => $response[0]['lat'],
            'longitude' => $response[0]['lon']
        ];
    }

    public function setBaseUrl($url) {
        $this->baseUrl = $url;
    }

}