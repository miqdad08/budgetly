<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $userId = 1; // ID user yang sudah ada

        // Pastikan user dengan ID 1 ada, jika tidak, buat dulu
        // Tapi kita asumsikan sudah ada.

        // Data kategori yang mungkin (pastikan kategori untuk user_id=1 atau global)
        // Kita bisa ambil dari database, atau hardcode id kategori yang sudah ada.
        // Untuk kemudahan, kita cari kategori dulu.
        $categories = $this->db->table('categories')
            ->where('user_id', $userId)
            ->orWhere('user_id', null)
            ->get()->getResultArray();

        $incomeCategories = array_filter($categories, fn($c) => $c['type'] == 'income');
        $expenseCategories = array_filter($categories, fn($c) => $c['type'] == 'expense');

        if (empty($incomeCategories) || empty($expenseCategories)) {
            echo "Pastikan ada kategori income dan expense untuk user_id $userId atau global.\n";
            return;
        }

        $incomeCatIds = array_column($incomeCategories, 'id');
        $expenseCatIds = array_column($expenseCategories, 'id');

        // Akun
        $accounts = $this->db->table('accounts')
            ->where('user_id', $userId)
            ->orWhere('user_id', null)
            ->get()->getResultArray();
        if (empty($accounts)) {
            echo "Tidak ada akun untuk user_id $userId.\n";
            return;
        }
        $accountIds = array_column($accounts, 'id');

        // Buat data transaksi untuk 6 bulan terakhir
        $months = 6;
        $transactions = [];

        for ($i = $months; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i months"));

            // Setiap bulan, buat 2-3 transaksi expense dan 1 income
            // Income di pertengahan bulan
            $incomeAmount = rand(5, 15) * 1000000; // 5-15 juta
            $incomeDay = rand(15, 20);
            $incomeDate = date('Y-m-d', strtotime($date . " +$incomeDay days"));
            $transactions[] = [
                'user_id' => $userId,
                'type' => 'income',
                'amount' => $incomeAmount,
                'category_id' => $incomeCatIds[array_rand($incomeCatIds)],
                'account_id' => $accountIds[array_rand($accountIds)],
                'date' => $incomeDate,
                'notes' => 'Gaji ' . date('F Y', strtotime($incomeDate)),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Expense di beberapa hari
            $expenseCount = rand(3, 5);
            for ($j = 0; $j < $expenseCount; $j++) {
                $expenseAmount = rand(10, 500) * 1000; // 10rb - 500rb
                $expenseDay = rand(1, 28);
                $expenseDate = date('Y-m-d', strtotime($date . " +$expenseDay days"));
                $transactions[] = [
                    'user_id' => $userId,
                    'type' => 'expense',
                    'amount' => $expenseAmount,
                    'category_id' => $expenseCatIds[array_rand($expenseCatIds)],
                    'account_id' => $accountIds[array_rand($accountIds)],
                    'date' => $expenseDate,
                    'notes' => 'Pengeluaran ' . $expenseDate,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        // Insert batch
        $this->db->table('transactions')->insertBatch($transactions);

        echo "Seeder berhasil menambahkan " . count($transactions) . " transaksi untuk user_id $userId.\n";
    }
}