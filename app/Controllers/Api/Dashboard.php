<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\AccountsModel;
use CodeIgniter\API\ResponseTrait;

class Dashboard extends BaseController
{
    use ResponseTrait;

    protected $transactionsModel;
    protected $accountsModel;

    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
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

        // Total balance
        $accounts = $this->accountsModel->where('user_id', $userId)->findAll();
        $totalBalance = array_sum(array_column($accounts, 'balance'));

        // Monthly income/expense
        $month = date('Y-m');
        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));

        $monthlyIncome = $this->transactionsModel
            ->selectSum('amount')
            ->where('user_id', $userId)
            ->where('type', 'income')
            ->where('date >=', $start)
            ->where('date <=', $end)
            ->get()
            ->getRowArray()['amount'] ?? 0;

        $monthlyExpense = $this->transactionsModel
            ->selectSum('amount')
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->where('date >=', $start)
            ->where('date <=', $end)
            ->get()
            ->getRowArray()['amount'] ?? 0;

        // Recent transactions
        $recent = $this->transactionsModel
            ->select('transactions.*, categories.name as category_name')
            ->join('categories', 'categories.id = transactions.category_id', 'left')
            ->where('transactions.user_id', $userId)
            ->orderBy('date', 'DESC')
            ->limit(5)
            ->findAll();

        // Spending trends (6 bulan)
        $trends = $this->getSpendingTrends($userId, 6);

        return $this->respond([
            'total_balance' => $totalBalance,
            'monthly_income' => $monthlyIncome,
            'monthly_expense' => $monthlyExpense,
            'recent_transactions' => $recent,
            'spending_trends' => $trends
        ]);
    }

    private function getSpendingTrends($userId, $months)
    {
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

        return [
            'labels' => array_map(function($m) {
                return date('M', strtotime($m . '-01'));
            }, array_keys($data)),
            'data' => array_values($data)
        ];
    }
}