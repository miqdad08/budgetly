<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use CodeIgniter\API\ResponseTrait;

class Accounts extends BaseController
{
    use ResponseTrait;

    protected $accountsModel;

    public function __construct()
    {
        $this->accountsModel = new AccountsModel();
    }

    private function getUserId()
    {
        return $this->request->user->id ?? null;
    }

    public function index()
    {
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        $accounts = $this->accountsModel->where('user_id', $userId)->findAll();
        return $this->respond($accounts);
    }

    public function show($id)
    {
        $userId = $this->getUserId();
        $account = $this->accountsModel->where('user_id', $userId)->find($id);
        if (!$account) {
            return $this->failNotFound('Akun tidak ditemukan');
        }
        return $this->respond($account);
    }

    public function create()
    {
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[bank,e-wallet,wallet]',
            'balance' => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'user_id' => $userId,
            'name'    => $this->request->getVar('name'),
            'type'    => $this->request->getVar('type'),
            'balance' => $this->request->getVar('balance') ?? 0,
        ];

        $this->accountsModel->insert($data);
        $id = $this->accountsModel->insertID();

        return $this->respondCreated([
            'status' => true,
            'message' => 'Akun berhasil ditambahkan',
            'data' => ['id' => $id]
        ]);
    }

    public function update($id)
    {
        $userId = $this->getUserId();
        $account = $this->accountsModel->where('user_id', $userId)->find($id);
        if (!$account) {
            return $this->failNotFound('Akun tidak ditemukan');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[bank,e-wallet,wallet]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'type' => $this->request->getVar('type'),
        ];

        $this->accountsModel->update($id, $data);

        return $this->respond([
            'status' => true,
            'message' => 'Akun berhasil diperbarui'
        ]);
    }

    public function delete($id)
    {
        $userId = $this->getUserId();
        $account = $this->accountsModel->where('user_id', $userId)->find($id);
        if (!$account) {
            return $this->failNotFound('Akun tidak ditemukan');
        }

        // Cek apakah akun masih memiliki transaksi
        $transactionModel = new \App\Models\TransactionsModel();
        if ($transactionModel->where('account_id', $id)->countAllResults() > 0) {
            return $this->fail('Akun masih memiliki transaksi', 400);
        }

        $this->accountsModel->delete($id);

        return $this->respond([
            'status' => true,
            'message' => 'Akun berhasil dihapus'
        ]);
    }
}