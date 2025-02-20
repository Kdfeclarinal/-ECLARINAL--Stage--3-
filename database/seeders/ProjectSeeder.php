<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            'Project X' => 'This is project Xavier',
            'Project Y' => 'This is project Yve',
            'Project Z' => 'This is project Zhuxin',
        ];

        foreach ($projects as $name => $description) {
            Project::factory()->create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}
