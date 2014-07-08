<?php

class MLoginController extends Controller {

    public function __construct(MitgliederService $mitgliederService) {
        $this->mitgliederService = $mitgliederService;
    }

    public function renderLogin() 
    {
        $mitglied = new Mitglied();

        return View::make('mlogin')
            ->with('mitglied', $mitglied)
            ->with('squadname', 'Flensburg - Tarp');
    }

    public function login() 
    {
        $rules = array(
            'passwort' => 'required',
            'email' => 'required|email'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('mobile/login')
                ->withErrors($validator)
                ->withInput(Input::except('passwort'));
        }

        if ($this->mitgliederService->authenticate(Input::get('email'), Input::get('passwort'))) 
        {
            return Redirect::to('mobile/dashboard');
        }

        return Redirect::to('mobile/login')
            ->withErrors(array(
                'autherror' => true));
    }

    public function ausloggen()
    {
        Auth::logout();
        return Redirect::to('mobile/login');
    }

}
