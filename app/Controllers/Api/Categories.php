<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class Categories extends BaseController
{
    use ResponseTrait;

    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
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

        // Ambil kategori milik user dan global
        $categories = $this->categoryModel
            ->groupStart()
                ->where('user_id', $userId)
                ->orWhere('user_id', null)
            ->groupEnd()
            ->findAll();

        return $this->respond($categories);
    }

    public function show($id)
    {
        $userId = $this->getUserId();
        $category = $this->categoryModel
            ->groupStart()
                ->where('user_id', $userId)
                ->orWhere('user_id', null)
            ->groupEnd()
            ->find($id);

        if (!$category) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }
        return $this->respond($category);
    }

    public function create()
    {
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[income,expense]',
            'icon' => 'required|string',
            'color' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'user_id' => $userId,
            'name'    => $this->request->getVar('name'),
            'type'    => $this->request->getVar('type'),
            'icon'    => $this->request->getVar('icon'),
            'color'   => $this->request->getVar('color') ?: 'slate',
        ];

        $this->categoryModel->insert($data);
        $id = $this->categoryModel->insertID();

        return $this->respondCreated([
            'status' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => ['id' => $id]
        ]);
    }

    public function update($id)
    {
        $userId = $this->getUserId();
        $category = $this->categoryModel->where('user_id', $userId)->find($id);
        if (!$category) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[income,expense]',
            'icon' => 'required|string',
            'color' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'type' => $this->request->getVar('type'),
            'icon' => $this->request->getVar('icon'),
            'color' => $this->request->getVar('color') ?: 'slate',
        ];

        $this->categoryModel->update($id, $data);

        return $this->respond([
            'status' => true,
            'message' => 'Kategori berhasil diperbarui'
        ]);
    }

    public function delete($id)
    {
        $userId = $this->getUserId();
        $category = $this->categoryModel->where('user_id', $userId)->find($id);
        if (!$category) {
            return $this->failNotFound('Kategori tidak ditemukan');
        }

        // Cek apakah kategori masih memiliki transaksi
        $transactionModel = new \App\Models\TransactionsModel();
        if ($transactionModel->where('category_id', $id)->countAllResults() > 0) {
            return $this->fail('Kategori masih memiliki transaksi', 400);
        }

        // Hard delete
        $this->categoryModel->delete($id, true);

        return $this->respond([
            'status' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}