<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $members = [
        'Kein Daryle' => 'Back-End Developer',
        'Gian Apostol' => 'Full-Stack Developer',
        'Henri Dillo' => 'Front-End Developer',
       ];
       
       foreach ($members as $member => $role) {
           Member::factory()->create([
            'name' => $member,
            'role' => $role,
           ]);
       }
    }
}
