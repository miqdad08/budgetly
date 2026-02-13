<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        
        // Cek apakah user sudah login
        if (! $session->get('isLogin')) {
            return redirect()->to('/login');
        }

        // Kirim data username ke view
        $data['username'] = $session->get('name');

        // Panggil view dashboard/index yang sudah menggunakan layout
        return view('dashboard/index', $data);
    }
}