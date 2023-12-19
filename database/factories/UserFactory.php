<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => 'NIK' . rand(1000000,9999999),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ];
    }

}
