<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a task that has been done
        Task::factory()->done()->count(2)->create();

        // Create a task that is still active
        Task::factory()->todo()->count(2)->create();
    }
}
