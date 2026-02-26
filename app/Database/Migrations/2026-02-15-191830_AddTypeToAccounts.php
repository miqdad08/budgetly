<?php
// app/Database/Migrations/2025_02_16_000001_add_type_to_accounts.php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTypeToAccounts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('accounts', [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['bank', 'e-wallet', 'wallet'],
                'default'    => 'bank',
                'after'      => 'name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('accounts', 'type');
    }
}