<?php

namespace Database\Seeders;

use App\Models\FinancialAccount;
use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultAccount = FinancialAccount::first();

        if (! $defaultAccount) {
            $this->command->warn('⚠️ Tidak ada data di financial_accounts. Seeder PaymentMethod dilewati.');
            return;
        }

        $methods = [
            [
                'code' => 'CASH',
                'name' => 'Cash',
                'description' => 'Cash Payment',
                'financial_account_id' => $defaultAccount->id,
                'fee_type' => 'None',
                'fee_account_id' => $defaultAccount->id,
            ],
            [
                'code' => 'BANK',
                'name' => 'Bank Transfer',
                'description' => 'Payment via bank transfer',
                'financial_account_id' => $defaultAccount->id,
                'fee_type' => 'Transfer Fee',
                'fee_account_id' => $defaultAccount->id,
            ],
            [
                'code' => 'CC',
                'name' => 'Credit Card',
                'description' => 'Payment via credit card',
                'financial_account_id' => $defaultAccount->id,
                'fee_type' => 'Credit Card Fee',
                'fee_account_id' => $defaultAccount->id,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }

        // $this->command->info('✅ Payment methods berhasil ditambahkan.');
    }
}
