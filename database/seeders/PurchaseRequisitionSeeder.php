<?php

namespace Database\Seeders;

use App\Models\PurchaseRequisition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseRequisitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('purchase_requisitions')->insert([
            [
                'code' => 'PR-' . strtoupper(Str::random(6)),
                'state' => 'Completed',
                'company_id' => 1,
                'bussiness_unit_id' => 1,
                'project_input' => 'Project Alpha',
                'warehouse_id' => 1,
                'delivery_method_id' => 1,
                'reference' => 'REF-001',
                'description' => 'Initial purchase requisition seeder',
                'user_id' => 1,
                'transaction_at' => now()->format('Y-m-d'),
                'required_at' => now()->addDays(7)->format('Y-m-d'),
                'contact_person_name_shipment' => 'John Doe',
                'contact_person_phone_shipment' => '081234567890',
                'address_shipment' => 'Jl. Merdeka No. 123, Jakarta',
                'currency_shipment_id' => 1,
                'postcode_shipment' => '12345',
                'template_company' => 'PT Contoh Makmur',
                'address_company' => 'Jl. Raya Industri No. 45',
                'currency_company_id' => 1,
                'postcode_company' => '54321',
                'image' => json_encode(['invoice1.png', 'invoice2.png']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
