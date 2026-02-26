<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Kategori income
            [
                'user_id' => null,
                'name'    => 'Gaji',
                'type'    => 'income',
                'icon'    => 'payments',
                'color'   => 'emerald',
            ],
            [
                'user_id' => null,
                'name'    => 'Bonus / Freelance',
                'type'    => 'income',
                'icon'    => 'work',
                'color'   => 'blue',
            ],
            [
                'user_id' => null,
                'name'    => 'Investasi',
                'type'    => 'income',
                'icon'    => 'trending_up',
                'color'   => 'purple',
            ],
            // Kategori expense
            [
                'user_id' => null,
                'name'    => 'Makanan',
                'type'    => 'expense',
                'icon'    => 'restaurant',
                'color'   => 'orange',
            ],
            [
                'user_id' => null,
                'name'    => 'Transportasi',
                'type'    => 'expense',
                'icon'    => 'directions_car',
                'color'   => 'amber',
            ],
            [
                'user_id' => null,
                'name'    => 'Belanja',
                'type'    => 'expense',
                'icon'    => 'shopping_bag',
                'color'   => 'pink',
            ],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}