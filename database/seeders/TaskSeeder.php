<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assurez-vous d'avoir des utilisateurs existants
        $user = User::first();

        if ($user) {
            Task::create([
                'title' => 'Task 1',
                'description' => 'Description for Task 1',
                'status' => 'pending',
                'due_date' => '2024-12-31',
                'user_id' => $user->id,
            ]);

            Task::create([
                'title' => 'Task 2',
                'description' => 'Description for Task 2',
                'status' => 'completed',
                'due_date' => '2024-11-30',
                'user_id' => $user->id,
            ]);
        }
    }
}
