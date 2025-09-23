<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'code' => 'CO0001',
                'name' => 'PT Enesers Mitra Berkah',
                'state' => 'Active',
                'tax_number' => 'TAX-' . rand(100000, 999999),
                'description' => 'Perusahaan distribusi alat kesehatan',
                'image' => json_encode(['logo' => 'majujaya.png']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
