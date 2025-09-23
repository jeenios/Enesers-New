<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('financial_reasons')->insert([
            [
                'code' => 'FR001',
                'state' => 'Active',
                'name' => 'Advance Payment',
                'financial_account_id' => 1,
                'description' => 'Reason for advance payment requests',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FR002',
                'state' => 'Active',
                'name' => 'Expense Reimbursement',
                'financial_account_id' => 1,
                'description' => 'Used for employee expense reimbursements',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FR003',
                'state' => 'Inactive',
                'name' => 'Petty Cash Usage',
                'financial_account_id' => 1,
                'description' => 'Petty cash transactions reason',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
