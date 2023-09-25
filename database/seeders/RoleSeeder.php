<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    const DEFAULT_RULES = [
        'administrator' => [
            'name' => 'Administrator',
            'is_permanent' => true,
        ],
        'manager' => [
            'name' => 'Manager',
            'is_permanent' => true,
        ],
        'operator' => [
            'name' => 'Operator',
            'is_permanent' => true,
        ],
    ];

    const ADMINISTRATOR_RULE_NAME = self::DEFAULT_RULES['administrator']['name'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::DEFAULT_RULES as $role) {
            Role::create($role);
        }

        // Assign administrator role to default account
        User::query()
            ->where('email', UserFactory::DEFAULT_USER_EMAIL)
            ->firstOrFail()
            ->assignRole(self::ADMINISTRATOR_RULE_NAME);
    }
}
