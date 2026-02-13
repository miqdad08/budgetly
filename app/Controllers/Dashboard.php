<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (! $session->get('isLogin')) {
            return redirect()->to('/login');
        }
        $data['username'] = $session->get('name');
        return view('dashboard', $data);
    }
}