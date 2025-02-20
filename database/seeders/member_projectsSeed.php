<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Project;

class member_projectsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $members = Member::factory()->count(10)->create();
        $projects = Project::factory()->count(5)->create();

        foreach ($members as $member) {
            $member->projects()->attach(
                $projects->random(rand(1,3))->pluck('id')->toArray(),
                ['assigned_at' => now()]
            );
        }
    }
}
