<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseRequisitionMultipleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchaseRequisitionId = DB::table('purchase_requisitions')->value('id');

        DB::table('purchase_requisition_multiples')->insert([
            [
                'purchase_requisition_id' => $purchaseRequisitionId,
                'item_id' => 1,
                'description' => 'Untuk project',
                'quantity' => 5,
                'unit_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'purchase_requisition_id' => $purchaseRequisitionId,
                'item_id' => 2,
                'description' => 'Untuk project',
                'quantity' => 2,
                'unit_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
