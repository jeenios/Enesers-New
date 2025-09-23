<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('warehouse_categories')->insert([
            [
                'code' => 'WC0001',
                'parent_category' => null,
                'name' => 'Raw Materials',
                'description' => 'Category for raw material warehouses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WC0002',
                'parent_category' => null,
                'name' => 'Finished Goods',
                'description' => 'Category for finished goods warehouses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WC0003',
                'parent_category' => 'FG',
                'name' => 'Distribution Warehouse',
                'description' => 'Subcategory under Finished Goods for distribution',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WC0004',
                'parent_category' => null,
                'name' => 'Spare Parts',
                'description' => 'Warehouse category for spare parts and components',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
