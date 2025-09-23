<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hospitals = [
            [
                'code' => 'HSP001',
                'state' => 'Active',
                'name' => 'RS Umum Jakarta',
                'kota' => 'Jakarta',
                'alamat' => 'Jl. Sudirman No. 1, Jakarta Pusat',
                'phone' => '021-123456',
                'kelas' => 'A',
                'pemilik' => 'Kemenkes',
            ],
            [
                'code' => 'HSP002',
                'state' => 'Active',
                'name' => 'RS Medika Bandung',
                'kota' => 'Bandung',
                'alamat' => 'Jl. Asia Afrika No. 88, Bandung',
                'phone' => '022-654321',
                'kelas' => 'B',
                'pemilik' => 'Swasta',
            ],
            [
                'code' => 'HSP003',
                'state' => 'Inactive',
                'name' => 'RS Sehat Makassar',
                'kota' => 'Makassar',
                'alamat' => 'Jl. Pettarani No. 22, Makassar',
                'phone' => '0411-987654',
                'kelas' => 'C',
                'pemilik' => 'Yayasan',
            ],
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
