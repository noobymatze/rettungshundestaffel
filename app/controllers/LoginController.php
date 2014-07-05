<?php

class LoginController extends Controller {

    public function __construct(MitgliederService $mitgliederService) {
        $this->mitgliederService = $mitgliederService;
    }

    public function renderLogin() 
    {
        $mitglied = new Mitglied;

        return View::make('login')
            ->with('mitglied', $mitglied);
    }

    public function login() 
    {
        $rules = array(
            'passwort' => 'required',
            'email' => 'required|email'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/login')
                ->withErrors($validator)
                ->withInput(Input::except('passwort'));
        }

        if ($this->mitgliederService->authenticate(Input::get('email'), Input::get('passwort'))) 
        {
            return Redirect::to('/');
        }

        return Redirect::to('/login')
            ->withErrors(array(
                'email' => 'E-Mail oder', 
                'passwort' => 'Passwort war nicht korrekt.'));
    }

}
