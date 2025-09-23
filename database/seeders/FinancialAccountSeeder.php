<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\FinancialAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currency = Currency::firstOrCreate(
            ['code' => 'IDR'],
            ['name' => 'Indonesian Rupiah']
        );

        FinancialAccount::create([
            'code'             => 'FA123',
            'state'            => 'Active',
            'name'             => 'Bank BRI',
            'description'      => 'Bank',
            'currency_id'      => $currency->id,
            'account_type'     => 'Bank',
            'allow_draft'      => true,
            'incoming_payment' => null,
            'outgoing_payment' => null,
            'account'          => null,
            'created_at'       => '2025-09-18 03:35:00',
            'updated_at'       => '2025-09-18 03:35:00',
        ]);
    } //
}
