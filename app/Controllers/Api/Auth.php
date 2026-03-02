<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AccountsModel;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Email atau password salah');
        }

        // Generate token acak 64 karakter
        $token = bin2hex(random_bytes(32));

        // Simpan token ke database
        $userModel->update($user['id'], ['token' => $token]);

        return $this->respond([
            'status' => true,
            'message' => 'Login sukses',
            'data' => [
                'token' => $token,
                'user' => [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email']
                ]
            ]
        ]);
    }

    public function register()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm'  => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $accountModel = new AccountsModel();

        $db = \Config\Database::connect();
        $db->transStart();

        $userId = $userModel->insert([
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        ]);

        // Buat akun default
        $accountModel->insert([
            'user_id' => $userId,
            'name'    => 'Bank',
            'type'    => 'bank',
            'balance' => 0
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->fail('Gagal registrasi, coba lagi');
        }

        return $this->respondCreated([
            'status' => true,
            'message' => 'Registrasi sukses, silakan login'
        ]);
    }

    public function logout()
    {
        $user = $this->request->user;
        $userModel = new UserModel();
        $userModel->update($user->id, ['token' => null]);

        return $this->respond([
            'status' => true,
            'message' => 'Logout sukses'
        ]);
    }
}