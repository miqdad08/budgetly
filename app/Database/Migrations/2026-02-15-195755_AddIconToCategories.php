<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIconToCategories extends Migration
{
    public function up()
    {
        $this->forge->addColumn('categories', [
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'type',
                'default'    => 'category',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('categories', 'icon');
    }
}