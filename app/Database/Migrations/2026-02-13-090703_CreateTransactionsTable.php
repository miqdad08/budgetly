<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'     => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'type'        => [
                'type'       => 'ENUM',
                'constraint' => ['income', 'expense'],
                'default'    => 'expense',
            ],
            'amount'      => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'account_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'date'        => [
                'type' => 'DATE',
            ],
            'notes'       => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('account_id', 'accounts', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('transactions');

        // Tambahan indeks untuk query umum
        $this->db->query('ALTER TABLE transactions ADD INDEX idx_user_date (user_id, date)');
        $this->db->query('ALTER TABLE transactions ADD INDEX idx_type (type)');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}