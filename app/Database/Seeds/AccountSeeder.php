<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua user yang sudah terdaftar
        $users = $this->db->table('users')->select('id')->get()->getResultArray();

        if (empty($users)) {
            echo "Tidak ada user. Jalankan UserSeeder terlebih dahulu.\n";
            return;
        }

        $accounts = [];
        foreach ($users as $user) {
            // Cek apakah user sudah punya akun
            $existing = $this->db->table('accounts')
                ->where('user_id', $user['id'])
                ->get()
                ->getRow();

            if (!$existing) {
                $accounts[] = [
                    'user_id'    => $user['id'],
                    'name'       => 'Bank',
                    'type'       => 'bank',
                    'balance'    => 0,                // sesuai permintaan, balance = 0
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        if (!empty($accounts)) {
            $this->db->table('accounts')->insertBatch($accounts);
            echo "Berhasil menambahkan " . count($accounts) . " akun bank untuk user.\n";
        } else {
            echo "Semua user sudah memiliki akun.\n";
        }
    }
}