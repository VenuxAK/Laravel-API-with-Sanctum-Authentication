<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Project::truncate();
        $randomUserID = count(User::pluck('id'));
        Project::factory(5)->create([
            "user_id" => fake()->numberBetween(1, $randomUserID)
        ]);
        Project::factory(3)->create([
            "user_id" => fake()->numberBetween(1, $randomUserID)
        ]);
        Project::factory(10)->create([
            "user_id" => fake()->numberBetween(1, $randomUserID)
        ]);
    }
}
