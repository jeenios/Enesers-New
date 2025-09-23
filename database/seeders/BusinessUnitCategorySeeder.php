<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessUnitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_unit_categories')->insert([
            [
                'code' => 'BS0001',
                'parent_category' => null,
                'name' => 'Corporate',
                'description' => 'Main corporate category',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'BS0002',
                'parent_category' => 'CAT001',
                'name' => 'Finance',
                'description' => 'Finance related units',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'BS0003',
                'parent_category' => 'CAT001',
                'name' => 'Human Resources',
                'description' => 'HR related units',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'BS0004',
                'parent_category' => null,
                'name' => 'Operations',
                'description' => 'Operations and production units',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
