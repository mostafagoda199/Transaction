<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => substr(fake()->name(),0,70),
            'slug' => substr(fake()->unique()->slug,0,70),
        ];
    }
}
