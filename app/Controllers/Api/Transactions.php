<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\AccountsModel;
use CodeIgniter\API\ResponseTrait;

class Transactions extends BaseController
{
    use ResponseTrait;

    protected $transactionsModel;

    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
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

        $month = $this->request->getGet('month');
        $categoryId = $this->request->getGet('category_id');
        $search = $this->request->getGet('search');
        $limit = $this->request->getGet('limit') ?? 10;
        $page = $this->request->getGet('page') ?? 1;

        $builder = $this->transactionsModel
            ->select('transactions.*, categories.name as category_name, categories.icon as category_icon, categories.color as category_color')
            ->join('categories', 'categories.id = transactions.category_id', 'left')
            ->where('transactions.user_id', $userId);

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
        $data = $builder->orderBy('date', 'DESC')->paginate($limit, 'default', $page);

        return $this->respond([
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'per_page' => $limit,
                'current_page' => $page,
                'last_page' => ceil($total / $limit)
            ]
        ]);
    }

    public function show($id)
    {
        $userId = $this->getUserId();
        $transaction = $this->transactionsModel
            ->select('transactions.*, categories.name as category_name, categories.icon as category_icon, categories.color as category_color')
            ->join('categories', 'categories.id = transactions.category_id', 'left')
            ->where('transactions.user_id', $userId)
            ->find($id);

        if (!$transaction) {
            return $this->failNotFound('Transaksi tidak ditemukan');
        }
        return $this->respond($transaction);
    }

    public function create()
    {
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        $rules = [
            'type' => 'required|in_list[income,expense]',
            'amount' => 'required|numeric|greater_than[0]',
            'category_id' => 'required|integer',
            'account_id' => 'required|integer',
            'date' => 'required|valid_date',
            'notes' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'user_id' => $userId,
            'type' => $this->request->getVar('type'),
            'amount' => $this->request->getVar('amount'),
            'category_id' => $this->request->getVar('category_id'),
            'account_id' => $this->request->getVar('account_id'),
            'date' => $this->request->getVar('date'),
            'notes' => $this->request->getVar('notes'),
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        $this->transactionsModel->insert($data);
        $id = $this->transactionsModel->insertID();

        $accountModel = new AccountsModel();
        $accountModel->updateBalanceByTransactionType(
            $data['account_id'],
            $data['type'],
            $data['amount']
        );

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->fail('Gagal menyimpan transaksi');
        }

        return $this->respondCreated([
            'status' => true,
            'message' => 'Transaksi berhasil ditambahkan',
            'data' => ['id' => $id]
        ]);
    }

    public function update($id)
    {
        $userId = $this->getUserId();
        $transaction = $this->transactionsModel->where('user_id', $userId)->find($id);
        if (!$transaction) {
            return $this->failNotFound('Transaksi tidak ditemukan');
        }

        $rules = [
            'type' => 'required|in_list[income,expense]',
            'amount' => 'required|numeric|greater_than[0]',
            'category_id' => 'required|integer',
            'account_id' => 'required|integer',
            'date' => 'required|valid_date',
            'notes' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = [
            'type' => $this->request->getVar('type'),
            'amount' => $this->request->getVar('amount'),
            'category_id' => $this->request->getVar('category_id'),
            'account_id' => $this->request->getVar('account_id'),
            'date' => $this->request->getVar('date'),
            'notes' => $this->request->getVar('notes'),
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        $this->transactionsModel->update($id, $data);

        $accountModel = new AccountsModel();
        $old = $transaction;

        if ($old['account_id'] != $data['account_id']) {
            // Akun berubah
            if ($old['type'] == 'income') {
                $accountModel->decreaseBalance($old['account_id'], $old['amount']);
            } else {
                $accountModel->increaseBalance($old['account_id'], $old['amount']);
            }
            if ($data['type'] == 'income') {
                $accountModel->increaseBalance($data['account_id'], $data['amount']);
            } else {
                $accountModel->decreaseBalance($data['account_id'], $data['amount']);
            }
        } else {
            if ($old['type'] != $data['type']) {
                // Tipe berubah
                if ($old['type'] == 'income') {
                    $accountModel->decreaseBalance($old['account_id'], $old['amount']);
                } else {
                    $accountModel->increaseBalance($old['account_id'], $old['amount']);
                }
                if ($data['type'] == 'income') {
                    $accountModel->increaseBalance($data['account_id'], $data['amount']);
                } else {
                    $accountModel->decreaseBalance($data['account_id'], $data['amount']);
                }
            } else {
                $diff = $data['amount'] - $old['amount'];
                if ($diff != 0) {
                    if ($data['type'] == 'income') {
                        $accountModel->increaseBalance($data['account_id'], $diff);
                    } else {
                        $accountModel->decreaseBalance($data['account_id'], $diff);
                    }
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->fail('Gagal memperbarui transaksi');
        }

        return $this->respond([
            'status' => true,
            'message' => 'Transaksi berhasil diperbarui'
        ]);
    }

    public function delete($id)
    {
        $userId = $this->getUserId();
        $transaction = $this->transactionsModel->where('user_id', $userId)->find($id);
        if (!$transaction) {
            return $this->failNotFound('Transaksi tidak ditemukan');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Reverse balance
        $accountModel = new AccountsModel();
        if ($transaction['type'] == 'income') {
            $accountModel->decreaseBalance($transaction['account_id'], $transaction['amount']);
        } else {
            $accountModel->increaseBalance($transaction['account_id'], $transaction['amount']);
        }

        // Hard delete
        $this->transactionsModel->delete($id, true);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->fail('Gagal menghapus transaksi');
        }

        return $this->respond([
            'status' => true,
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }

    public function trends()
    {
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        $period = $this->request->getGet('period') ?? 6;
        $months = (int) $period;

        $data = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $data[$month] = 0;
        }

        $start = array_key_first($data) . '-01';
        $end = date('Y-m-t', strtotime(array_key_last($data) . '-01'));

        $rows = $this->transactionsModel
            ->select("DATE_FORMAT(date, '%Y-%m') as month, SUM(amount) as total")
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->where('date >=', $start)
            ->where('date <=', $end)
            ->groupBy('month')
            ->findAll();

        foreach ($rows as $row) {
            $data[$row['month']] = (float) $row['total'];
        }

        return $this->respond([
            'labels' => array_map(function ($m) {
                return date('M', strtotime($m . '-01'));
            }, array_keys($data)),
            'data' => array_values($data)
        ]);
    }

    public function recent()
    {
        $userId = $this->getUserId();
        if (!$userId) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        $transactions = $this->transactionsModel
            ->select('transactions.*, categories.name as category_name, categories.icon as category_icon')
            ->join('categories', 'categories.id = transactions.category_id', 'left')
            ->where('transactions.user_id', $userId)
            ->orderBy('date', 'DESC')
            ->limit(5)
            ->findAll();

        return $this->respond($transactions);
    }
}