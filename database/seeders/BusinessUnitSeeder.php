<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_units')->insert([
            [
                'code' => 'BU0001',
                'state' => 'Active',
                'name' => 'Finance Division',
                'description' => 'Handles company financial operations',
                'business_unit_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'BU0002',
                'state' => 'Active',
                'name' => 'Human Resources',
                'description' => 'Handles HR operations',
                'business_unit_category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'BU0003',
                'state' => 'Inactive',
                'name' => 'IT Department',
                'description' => 'Handles IT support and infrastructure',
                'business_unit_category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
