<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTokenToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
                'after' => 'password',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'token');
    }
}
