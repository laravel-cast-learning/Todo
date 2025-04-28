<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['name' => 'pending', 'color' => '#FFFF00']);
        Status::create(['name' => 'in progress','color' => '#0000FF']);
        Status::create(['name' => 'completed','color' => '#00FF00']);
    }
}
