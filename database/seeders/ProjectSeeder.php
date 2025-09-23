<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $partnerId         = DB::table('partners')->inRandomOrder()->value('id');
        $userId            = DB::table('users')->inRandomOrder()->value('id');
        $projectCategoryId = DB::table('project_categories')->inRandomOrder()->value('id');

        foreach (range(1, 5) as $i) {
            DB::table('projects')->insert([
                'code'                => 'PRJ-' . Str::upper(Str::random(6)),
                'state'               => fake()->randomElement(['Active', 'Inactive']),
                'name'                => fake()->words(3, true),
                'description'         => fake()->sentence(),
                'partner_id'          => $partnerId,
                'user_id'             => $userId,
                'project_category_id' => $projectCategoryId,
                'start_at'            => now()->subDays(rand(5, 20))->toDateString(),
                'due_at'              => now()->addDays(rand(10, 30))->toDateString(),
                'end_at'              => now()->addDays(rand(40, 60))->toDateString(),
                'image'               => fake()->imageUrl(640, 480, 'business', true),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
    }
}
