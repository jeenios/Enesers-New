<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashAdvanceReasonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cash_advance_reasons')->insert([
            [
                'code' => 'CAR-001',
                'state' => 'Active',
                'name' => 'Operational Expense',
                'financial_account_id' => 1,
                'description' => 'Cash advance for daily operational needs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'CAR-002',
                'state' => 'Active',
                'name' => 'Project Expense',
                'financial_account_id' => 1,
                'description' => 'Cash advance for project related activities',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'CAR-003',
                'state' => 'Inactive',
                'name' => 'Travel Expense',
                'financial_account_id' => 1,
                'description' => 'Cash advance for employee travel expenses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
