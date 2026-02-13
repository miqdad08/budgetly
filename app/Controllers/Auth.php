<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        helper(['form']);
        return view('auth/login');
    }

    public function register()
    {
        helper(['form']);
        return view('auth/register');
    }

    public function loginAction()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'isLogin' => true,
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->withInput()->with('error', 'Incorrect email or password. Please try again.');
        }
    }

    // ========== PROSES REGISTER ==========
    public function registerSave()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            // Validasi gagal -> kirim error per field
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ]);

        return redirect()->to('/login')->with('success', 'Registration successful! Please log in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
