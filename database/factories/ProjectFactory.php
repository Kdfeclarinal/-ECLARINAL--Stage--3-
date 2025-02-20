<?php

namespace Database\Factories;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project; 

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Default Name',
            'description' => 'Default Description',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
