<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // default user create
        if (!User::where('email', UserFactory::DEFAULT_USER_EMAIL)->exists()) {
            User::factory()->default()->create();
        }

        User::factory(10)->create();
    }
}
