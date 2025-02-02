<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;
    
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'), // default password
        ];
    }
    
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
            ];
        });
    }
} 