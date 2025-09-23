<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_categories')->insert([
            [
                'code' => 'IC0001',
                'parent_category' => null,
                'name' => 'Anesthesia Machine',
                'description' => 'Items used as raw materials in production',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'IC0002',
                'parent_category' => null,
                'name' => 'Ultrasonografi',
                'description' => 'Items that are finished products ready for sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'IC0003',
                'parent_category' => null,
                'name' => 'Lampu Operasi',
                'description' => 'Items for spare parts and components',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'IC0004',
                'parent_category' => 'SP',
                'name' => 'Baby Incubator',
                'description' => 'Electronic spare parts under Spare Parts category',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'IC0005',
                'parent_category' => 'SP',
                'name' => 'Suction Pump',
                'description' => 'Mechanical spare parts under Spare Parts category',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
