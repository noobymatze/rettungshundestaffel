<?php

class LoginController extends Controller {

    public function renderLogin() 
    {
        return View::make('login')
            ->with('title', 'Hallo Eugen');
    }

}
