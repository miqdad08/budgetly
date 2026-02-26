<?php

namespace App\Controllers;

use App\Models\TransactionsModel;
use App\Models\AccountsModel;

class Dashboard extends BaseController
{
    protected $transactionsModel;
    protected $accountsModel;

    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
        $this->accountsModel     = new AccountsModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Ambil periode dari dropdown (default 6 bulan)
        $period = $this->request->getGet('period') ?? '6';

        // Data statistik
        $totalBalance   = $this->getTotalBalance($userId);
        $monthlyIncome  = $this->getMonthlyTotal($userId, 'income');
        $monthlyExpense = $this->getMonthlyTotal($userId, 'expense');

        // Recent transactions
        $recentTransactions = $this->transactionsModel
            ->select('transactions.*, categories.name as category_name')
            ->join('categories', 'categories.id = transactions.category_id', 'left')
            ->where('transactions.user_id', $userId)
            ->orderBy('date', 'DESC')
            ->limit(5)
            ->findAll();

        // Spending trends sesuai periode
        $spendingTrends = $this->getSpendingTrends($userId, $period);

        $data = [
            'username'           => session()->get('name') ?? 'User',
            'totalBalance'       => $totalBalance,
            'monthlyIncome'      => $monthlyIncome,
            'monthlyExpense'     => $monthlyExpense,
            'recentTransactions' => $recentTransactions,
            'spendingTrends'     => $spendingTrends,
            'period'             => $period,
        ];

        return view('dashboard/index', $data);
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

    private function getMonthlyTotal($userId, $type)
    {
        $month = date('Y-m');
        $start = $month . '-01';
        $end   = date('Y-m-t', strtotime($start));

        $result = $this->transactionsModel
            ->select('SUM(amount) as total')
            ->where('user_id', $userId)
            ->where('type', $type)
            ->where('date >=', $start)
            ->where('date <=', $end)
            ->get()
            ->getRowArray();

        return $result['total'] ?? 0;
    }

    /**
     * Mengambil data pengeluaran per bulan untuk periode tertentu
     *
     * @param int $userId
     * @param int $months Jumlah bulan (6 atau 12)
     * @return array
     */
    private function getSpendingTrends($userId, $months = 6)
    {
        $months = (int) $months;
        $data = [];

        // Buat array bulan dengan nilai default 0
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $data[$month] = 0;
        }

        $start = array_key_first($data) . '-01';
        $end   = date('Y-m-t', strtotime(array_key_last($data) . '-01'));

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

        // Format untuk chart
        return [
            'labels' => array_map(function($m) {
                return date('M', strtotime($m . '-01'));
            }, array_keys($data)),
            'data'   => array_values($data)
        ];
    }
}