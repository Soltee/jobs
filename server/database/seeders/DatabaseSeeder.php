<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use Database\Factories\JobFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\User::factory()->count(50)->create();
        \App\Models\Job::factory()->count(100)->create();
        // User::factory(10)->create();
    }
}
