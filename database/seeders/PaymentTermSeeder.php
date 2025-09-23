<?php

namespace Database\Seeders;

use App\Models\PaymentTerm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'code'          => 'PT001',
                'state'         => 'Active',
                'name'          => 'Cash on Delivery',
                'description'   => 'Payment is due at the time of delivery.',
                'number_of_days' => '0',
            ],
            [
                'code'          => 'PT002',
                'state'         => 'Active',
                'name'          => 'Net 7',
                'description'   => 'Payment is due within 7 days.',
                'number_of_days' => '7',
            ],
            [
                'code'          => 'PT003',
                'state'         => 'Active',
                'name'          => 'Net 14',
                'description'   => 'Payment is due within 14 days.',
                'number_of_days' => '14',
            ],
            [
                'code'          => 'PT004',
                'state'         => 'Active',
                'name'          => 'Net 30',
                'description'   => 'Payment is due within 30 days.',
                'number_of_days' => '30',
            ],
            [
                'code'          => 'PT005',
                'state'         => 'Inactive',
                'name'          => 'Advance Payment',
                'description'   => 'Payment must be made in advance before goods/services are delivered.',
                'number_of_days' => '0',
            ],
        ];

        foreach ($data as $item) {
            PaymentTerm::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
