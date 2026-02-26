<?php

namespace App\Controllers;

use App\Models\TransactionsModel;
use App\Models\CategoryModel;
use App\Models\AccountsModel;

class Transactions extends BaseController
{
    protected $transactionsModel;
    protected $categoryModel;
    protected $accountsModel;

    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
        $this->categoryModel = new CategoryModel();
        $this->accountsModel = new AccountsModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil parameter filter
        $month = $this->request->getGet('month');
        $categoryId = $this->request->getGet('category');
        $search = $this->request->getGet('search');
        $page = $this->request->getGet('page') ?? 1;

        // Jika bulan tidak dipilih, gunakan bulan saat ini
        if (!$month) {
            $month = date('Y-m');
        }

        // Data statistik (sebagai angka, belum diformat)
        $totalBalance = $this->getTotalBalance($userId);
        $monthlyIncome = $this->getMonthlyTotal($userId, 'income', $month);
        $monthlyExpense = $this->getMonthlyTotal($userId, 'expense', $month);

        // Data dropdown
        $availableMonths = $this->getAvailableMonths($userId);
        $categories = $this->categoryModel->getUserCategories($userId);

        // Ambil transaksi dengan filter
        $transactions = $this->getTransactionHistory($userId, $month, $categoryId, $search, $page);

        $data = [
            'title' => 'Transactions',
            'activeMenu' => 'transactions',
            'totalBalance' => $totalBalance,
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpense' => $monthlyExpense,
            'month' => $month,
            'availableMonths' => $availableMonths,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'search' => $search,
            'transactions' => $transactions['data'],
            'pager' => $transactions['pager'],
            'totalRows' => $transactions['total'],
            'perPage' => $transactions['perPage'],
            'currentPage' => $page,
        ];

        return view('transactions/index', $data);
    }

    private function getTotalBalance($userId)
    {
        if (!$userId || !$this->accountsModel) {
            return 0;
        }
        $accounts = $this->accountsModel->getUserAccounts($userId);
        $total = 0;
        foreach ($accounts as $acc) {
            $total += floatval($acc['balance'] ?? 0);
        }
        return $total;
    }

    private function getMonthlyTotal($userId, $type, $month)
    {
        if (!$month) {
            return 0;
        }
        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));

        $result = $this->transactionsModel->select('SUM(amount) as total')->where('user_id', $userId)->where('type', $type)->where('date >=', $start)->where('date <=', $end)->get()->getRowArray();

        return $result['total'] ?? 0;
    }

    private function getAvailableMonths($userId)
    {
        $rows = $this->transactionsModel->select("DATE_FORMAT(date, '%Y-%m') as month", false)->where('user_id', $userId)->groupBy('month')->orderBy('month', 'DESC')->findAll();

        $months = [];
        foreach ($rows as $row) {
            $months[$row['month']] = date('F Y', strtotime($row['month'] . '-01'));
        }
        return $months;
    }

    private function getTransactionHistory($userId, $month, $categoryId = null, $search = null, $page = 1, $perPage = 10)
    {
        $builder = $this->transactionsModel->select('transactions.*, categories.name as category_name, categories.type as category_type')->join('categories', 'categories.id = transactions.category_id', 'left')->where('transactions.user_id', $userId);

        if ($month) {
            $start = $month . '-01';
            $end = date('Y-m-t', strtotime($start));
            $builder->where('date >=', $start)->where('date <=', $end);
        }

        if ($categoryId && $categoryId !== 'all') {
            $builder->where('category_id', $categoryId);
        }

        if ($search) {
            $builder->like('notes', $search);
        }

        $total = $builder->countAllResults(false);
        $data = $builder->orderBy('date', 'DESC')->paginate($perPage, 'default', $page);

        return [
            'data' => $data,
            'pager' => $this->transactionsModel->pager,
            'total' => $total,
            'perPage' => $perPage,
        ];
    }

    public function history()
    {
        $data = [
            'pageTitle' => 'Transaction History',
            'activeMenu' => 'transactions', // sudah ada
        ];
        return view('transactions/history', $data);
    }

    // CRUD
    public function create()
    {
        $userId = session()->get('user_id');
        $data = [
            'activeMenu' => 'transactions',
            'categories' => $this->categoryModel->getUserCategories($userId),
            'accounts' => $this->accountsModel->getUserAccounts($userId),
        ];
        return view('transactions/create', $data);
    }

    public function store()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Sesi habis, silakan login ulang');
        }

        $data = [
            'user_id' => $userId,
            'type' => $this->request->getPost('type'),
            'amount' => $this->request->getPost('amount'),
            'category_id' => $this->request->getPost('category_id'),
            'account_id' => $this->request->getPost('account_id'),
            'date' => $this->request->getPost('date'),
            'notes' => $this->request->getPost('notes'),
        ];

        if ($this->transactionsModel->insert($data)) {
            session()->setFlashdata('success', 'Transaksi berhasil ditambahkan');
            return redirect()->to('/transactions');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->transactionsModel->errors());
        }
    }

    public function edit($id)
    {
        $userId = session()->get('user_id');
        $transaction = $this->transactionsModel->where('user_id', $userId)->find($id);
        if (!$transaction) {
            return redirect()->to('/transactions')->with('error', 'Transaksi tidak ditemukan');
        }

        $data = [
            'transaction' => $transaction,
            'activeMenu' => 'transactions',
            'categories' => $this->categoryModel->getUserCategories($userId),
            'accounts' => $this->accountsModel->getUserAccounts($userId),
        ];
        return view('transactions/edit', $data);
    }

    public function update($id)
    {
        $userId = session()->get('user_id');
        $transaction = $this->transactionsModel->where('user_id', $userId)->find($id);
        if (!$transaction) {
            return redirect()->to('/transactions')->with('error', 'Transaksi tidak ditemukan');
        }

        $data = [
            'type' => $this->request->getPost('type'),
            'amount' => $this->request->getPost('amount'), // sudah numerik dari hidden input
            'category_id' => $this->request->getPost('category_id'),
            'account_id' => $this->request->getPost('account_id'),
            'date' => $this->request->getPost('date'),
            'notes' => $this->request->getPost('notes'),
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        // Update transaksi
        if (!$this->transactionsModel->update($id, $data)) {
            $db->transRollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->transactionsModel->errors());
        }

        // Ambil data lama dan baru
        $old = $transaction;
        $new = $data;

        // Kasus 1: Akun berubah
        if ($old['account_id'] != $new['account_id']) {
            // Kembalikan saldo dari akun lama
            if ($old['type'] == 'income') {
                $this->accountsModel->decreaseBalance($old['account_id'], $old['amount']);
            } else {
                $this->accountsModel->increaseBalance($old['account_id'], $old['amount']);
            }
            // Terapkan ke akun baru
            if ($new['type'] == 'income') {
                $this->accountsModel->increaseBalance($new['account_id'], $new['amount']);
            } else {
                $this->accountsModel->decreaseBalance($new['account_id'], $new['amount']);
            }
        } else {
            // Akun sama
            if ($old['type'] != $new['type']) {
                // Tipe berubah: balikkan efek lama, terapkan efek baru
                if ($old['type'] == 'income') {
                    $this->accountsModel->decreaseBalance($old['account_id'], $old['amount']);
                } else {
                    $this->accountsModel->increaseBalance($old['account_id'], $old['amount']);
                }
                if ($new['type'] == 'income') {
                    $this->accountsModel->increaseBalance($new['account_id'], $new['amount']);
                } else {
                    $this->accountsModel->decreaseBalance($new['account_id'], $new['amount']);
                }
            } else {
                // Tipe sama: hitung selisih
                $diff = $new['amount'] - $old['amount'];
                if ($diff != 0) {
                    if ($new['type'] == 'income') {
                        $this->accountsModel->increaseBalance($new['account_id'], $diff);
                    } else {
                        $this->accountsModel->decreaseBalance($new['account_id'], $diff);
                    }
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memperbarui transaksi');
        }

        session()->setFlashdata('success', 'Transaksi berhasil diperbarui');
        return redirect()->to('/transactions');
    }

    public function delete($id)
    {
        $userId = session()->get('user_id');
        $transaction = $this->transactionsModel->where('user_id', $userId)->find($id);
        if (!$transaction) {
            return redirect()->to('/transactions')->with('error', 'Transaksi tidak ditemukan');
        }

        if ($this->transactionsModel->deleteTransaction($id)) {
            session()->setFlashdata('success', 'Transaksi berhasil dihapus dan saldo diperbarui');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus transaksi');
        }
        return redirect()->to('/transactions');
    }
}
