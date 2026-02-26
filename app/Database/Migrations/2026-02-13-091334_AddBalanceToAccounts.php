<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBalanceToAccounts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('accounts', [
            'balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0.00,
                'after'      => 'name', // letakkan setelah kolom name (opsional)
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('accounts', 'balance');
    }
}