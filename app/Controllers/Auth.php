<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        $session = session();

        if ($session->get('isLogin')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function register()
    {
        helper(['form']);
        return view('auth/register');
    }

    public function loginAction()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session dengan key yang konsisten
            $sessionData = [
                'isLogin' => true,
                'user_id' => $user['id'], // gunakan 'user_id', bukan 'id'
                'name' => $user['name'],
                'email' => $user['email'],
            ];
            $session->set($sessionData);

            return redirect()->to('/dashboard');
        } else {
            $session->setFlashdata('error', 'Email atau password salah');
            return redirect()->back()->withInput();
        }
    }

    public function registerSave()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $userId = $userModel->insert([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);

        // Buat akun default untuk user baru
        $accountModel = new \App\Models\AccountsModel();
        $accountModel->insert([
            'user_id' => $userId,
            'name' => 'Bank',
            'type' => 'bank',
            'balance' => 0,
        ]);

        return redirect()->to('/login')->with('success', 'Registration successful! Please log in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
