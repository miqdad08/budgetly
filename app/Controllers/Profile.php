<?php

namespace App\Controllers;

use App\Models\AccountsModel;
use App\Models\CategoryModel;

class Profile extends BaseController
{
    protected $accountsModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->accountsModel = new AccountsModel();
        $this->categoryModel = new CategoryModel();
    }

    // Halaman utama profile
    public function index()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = [
            'name' => session()->get('name'),
            'email' => session()->get('email'),
        ];

        // Ambil akun milik user saja (tidak termasuk global)
        $accounts = $this->accountsModel->where('user_id', $userId)->findAll();

        // Ambil kategori global + milik user
        $categories = $this->categoryModel->where('user_id', $userId)->orWhere('user_id', null)->findAll();

        $expenseCategories = array_filter($categories, fn($cat) => $cat['type'] === 'expense');
        $incomeCategories = array_filter($categories, fn($cat) => $cat['type'] === 'income');

        $data = [
            'user' => $user,
            'accounts' => $accounts,
            'expenseCategories' => $expenseCategories,
            'incomeCategories' => $incomeCategories,
            'activeMenu' => 'profile',
        ];

        return view('profile/index', $data);
    }

    // --------------------------------------------------------------------
    // CRUD Accounts
    // --------------------------------------------------------------------

    // Form tambah akun
    public function createAccount()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $data = [
            'title' => 'Tambah Akun',
            'activeMenu' => 'profile',
        ];
        return view('profile/create_account', $data);
    }

    // Simpan akun baru
    public function storeAccount()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[bank,e-wallet,wallet]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'user_id' => $userId,
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'balance' => $this->request->getPost(index: 'balance'),
        ];

        $this->accountsModel->insert($data);
        session()->setFlashdata('success', 'Akun berhasil ditambahkan');
        return redirect()->to('/profile');
    }

    // Form edit akun
    public function editAccount($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $account = $this->accountsModel->where('user_id', $userId)->find($id);
        if (!$account) {
            return redirect()->to('/profile')->with('error', 'Akun tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Akun',
            'account' => $account,
            'activeMenu' => 'profile',
        ];
        return view('profile/edit_account', $data);
    }

    // Update akun
    public function updateAccount($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $account = $this->accountsModel->where('user_id', $userId)->find($id);
        if (!$account) {
            return redirect()->to('/profile')->with('error', 'Akun tidak ditemukan');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[bank,e-wallet,wallet]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
        ];

        $this->accountsModel->update($id, $data);
        session()->setFlashdata('success', 'Akun berhasil diperbarui');
        return redirect()->to('/profile');
    }

    // Hapus akun
    public function deleteAccount($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $account = $this->accountsModel->where('user_id', $userId)->find($id);
        if (!$account) {
            return redirect()->to('/profile')->with('error', 'Akun tidak ditemukan');
        }

        // Cek apakah akun masih memiliki transaksi? Jika ya, mungkin perlu penanganan khusus.
        // Sederhananya, kita bisa hapus (soft delete) karena ada useSoftDeletes.
        $this->accountsModel->delete($id);
        session()->setFlashdata('success', 'Akun berhasil dihapus');
        return redirect()->to('/profile');
    }

    public function createCategory()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('profile/create_category');
    }

    public function storeCategory()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[income,expense]',
            'icon' => 'required|string',
            'color' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'user_id' => $userId,
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'icon' => $this->request->getPost('icon'),
            'color' => $this->request->getPost('color') ?: 'slate',
        ];

        $this->categoryModel->insert($data);
        session()->setFlashdata('success', 'Kategori berhasil ditambahkan');
        return redirect()->to('/profile');
    }

    public function editCategory($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $category = $this->categoryModel->where('user_id', $userId)->find($id);

        if (!$category) {
            return redirect()->to('/profile')->with('error', 'Kategori tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Kategori',
            'category' => $category,
            'activeMenu' => 'profile',
        ];

        return view('profile/edit_category', $data);
    }

    public function updateCategory($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $category = $this->categoryModel->where('user_id', $userId)->find($id);
        if (!$category) {
            return redirect()->to('/profile')->with('error', 'Kategori tidak ditemukan');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'type' => 'required|in_list[income,expense]',
            'icon' => 'required|string',
            'color' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'icon' => $this->request->getPost('icon'),
            'color' => $this->request->getPost('color') ?: 'slate',
        ];

        $this->categoryModel->update($id, $data);
        session()->setFlashdata('success', 'Kategori berhasil diperbarui');
        return redirect()->to('/profile');
    }

    public function deleteCategory($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cari kategori milik user (termasuk yang sudah soft delete jika ada)
        $category = $this->categoryModel->withDeleted()->where('user_id', $userId)->find($id);

        if (!$category) {
            return redirect()->to('/profile')->with('error', 'Kategori tidak ditemukan');
        }

        // Hard delete permanen
        if ($this->categoryModel->delete($id, true)) {
            session()->setFlashdata('success', 'Kategori berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus kategori');
        }

        return redirect()->to('/profile');
    }
}
