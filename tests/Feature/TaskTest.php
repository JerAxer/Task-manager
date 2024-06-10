<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crée un utilisateur pour chaque test
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_task()
    {
        $taskData = [
            'title' => 'Task Title',
            'description' => 'Task Description',
            'status' => 'pending',
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)->postJson('/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJson($taskData);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    //Test de récupération de toutes les tâches

    public function test_user_can_retrieve_all_tasks()
{
    Task::factory(3)->create(); // Crée 3 tâches dans la base de données

    $response = $this->actingAs($this->user)->getJson('/tasks');

    $response->assertStatus(200)
        ->assertJsonCount(3); // Vérifie que le nombre de tâches retournées est correct
}


//Test de récupération des détails d'une tâche spécifique

public function test_user_can_retrieve_specific_task_details()
{
    $task = Task::factory()->create(); // Crée une tâche dans la base de données

    $response = $this->actingAs($this->user)->getJson('/tasks/' . $task->id);

    $response->assertStatus(200)
        ->assertJson($task->toArray()); // Vérifie que les détails de la tâche retournée correspondent à la tâche créée
}

//Test de mise à jour d'une tâche

public function test_user_can_update_task()
{
    $task = Task::factory()->create(); // Crée une tâche dans la base de données

    $updatedTaskData = [
        'title' => 'Updated Task Title',
        'description' => 'Updated Task Description',
        'status' => 'completed',
        'due_date' => now()->addDays(5)->format('Y-m-d'),
    ];

    $response = $this->actingAs($this->user)->putJson('/tasks/' . $task->id, $updatedTaskData);

    $response->assertStatus(200)
        ->assertJson($updatedTaskData);

    $this->assertDatabaseHas('tasks', $updatedTaskData);
}

//Test de suppression d'une tâche

public function test_user_can_delete_task()
{
    $task = Task::factory()->create(); // Crée une tâche dans la base de données

    $response = $this->actingAs($this->user)->deleteJson('/tasks/' . $task->id);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Task deleted successfully']);

    $this->assertSoftDeleted('tasks', ['id' => $task->id]);
}

}
