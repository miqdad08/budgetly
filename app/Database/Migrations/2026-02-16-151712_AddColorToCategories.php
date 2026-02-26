<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColorToCategories extends Migration
{
    public function up()
    {
        $this->forge->addColumn('categories', [
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'default'    => 'slate',
                'after'      => 'icon',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('categories', 'color');
    }
}