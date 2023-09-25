<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public const DEFAULT_USER_NAME = 'Administrator';
    public const DEFAULT_USER_EMAIL = 'administrator@maxsop.com';
    public const DEFAULT_USER_PHONE = '01234567890';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->e164PhoneNumber(),
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model's for default admin.
     *
     * @return static
     */
    public function default()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => self::DEFAULT_USER_NAME,
                'email' => self::DEFAULT_USER_EMAIL,
                'phone' => self::DEFAULT_USER_PHONE,
            ];
        });
    }
}
