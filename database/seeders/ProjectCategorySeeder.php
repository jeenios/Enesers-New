<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'code'        => 'CAT-' . Str::upper(Str::random(4)),
                'parent_category' => null,
                'name'        => 'Construction',
                'description' => 'Construction related projects',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'CAT-' . Str::upper(Str::random(4)),
                'parent_category' => null,
                'name'        => 'IT Solutions',
                'description' => 'Technology and software projects',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'CAT-' . Str::upper(Str::random(4)),
                'parent_category' => null,
                'name'        => 'Marketing',
                'description' => 'Marketing and advertising campaigns',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('project_categories')->insert($categories);
    }
}
