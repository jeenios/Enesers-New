<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            [
                'code' => 'PC',
                'state' => 'Active',
                'name' => 'Pieces',
                'symbol' => 'pcs',
                'description' => null,
                'created_at' => '2022-03-07 16:23:00',
                'updated_at' => '2022-03-07 16:23:00',
            ],
            [
                'code' => 'ST',
                'state' => 'Active',
                'name' => 'Set',
                'symbol' => 'set',
                'description' => null,
                'created_at' => '2022-03-07 16:23:00',
                'updated_at' => '2022-03-07 16:23:00',
            ],
            [
                'code' => 'UN',
                'state' => 'Active',
                'name' => 'Unit',
                'symbol' => 'unit',
                'description' => null,
                'created_at' => '2022-03-07 16:23:00',
                'updated_at' => '2022-03-07 16:23:00',
            ],
            [
                'code' => 'BX',
                'state' => 'Active',
                'name' => 'Box',
                'symbol' => 'box',
                'description' => null,
                'created_at' => '2022-03-10 11:07:00',
                'updated_at' => '2022-03-10 11:07:00',
            ],
            [
                'code' => 'CM',
                'state' => 'Active',
                'name' => 'Centimeter',
                'symbol' => 'cm',
                'description' => null,
                'created_at' => '2022-03-10 11:07:00',
                'updated_at' => '2022-03-10 11:07:00',
            ],
            [
                'code' => 'CT',
                'state' => 'Active',
                'name' => 'Carton',
                'symbol' => 'carton',
                'description' => null,
                'created_at' => '2022-03-10 11:07:00',
                'updated_at' => '2022-03-10 11:07:00',
            ],
            [
                'code' => 'G',
                'state' => 'Active',
                'name' => 'Gram',
                'symbol' => 'g',
                'description' => null,
                'created_at' => '2022-03-10 11:07:00',
                'updated_at' => '2022-03-10 11:07:00',
            ],
            [
                'code' => 'KG',
                'state' => 'Active',
                'name' => 'Kilogram',
                'symbol' => 'kg',
                'description' => null,
                'created_at' => '2022-03-10 11:07:00',
                'updated_at' => '2022-03-10 11:07:00',
            ],
            [
                'code' => 'KM',
                'state' => 'Active',
                'name' => 'Kilometer',
                'symbol' => 'km',
                'description' => null,
                'created_at' => '2022-03-10 11:07:00',
                'updated_at' => '2022-03-10 11:07:00',
            ],
            [
                'code' => 'L',
                'state' => 'Active',
                'name' => 'Liter',
                'symbol' => 'l',
                'description' => null,
                'created_at' => '2022-03-10 11:07:00',
                'updated_at' => '2022-03-10 11:07:00',
            ],
        ]);
    }
}
