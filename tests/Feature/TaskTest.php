<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

   public function test_fetch_all_tasks_from_a_todolist() {
        $todolist = TodoList::factory()->create();
        $task = Task::factory()->create([
          'todolist_id' => $todolist->id
        ]);
        $response = $this->getJson(route('task.index', $todolist->id))
            ->assertOk()
            ->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
        $this->assertEquals($response[0]['todolist_id'], $todolist->id);
   }

   public function test_store_a_task_for_a_todolist() {
        $todolist = TodoList::factory()->create();
        $task = Task::factory()->create([
          'todolist_id' => $todolist->id
        ]);
        $this->postJson(route('task.store', $todolist->id), ['title' => $task->title])
            ->assertCreated();

        $this->assertDatabaseHas('tasks', ['title' => $task->title, 'todolist_id' => $todolist->id]);
   }

   public function test_delete_a_task_from_database() {
        $task = Task::factory()->create();
        $this->deleteJson(route('task.destroy', $task->id));

        $this->assertDatabaseMissing('tasks', ['title' => $task->title]);
   }

   public function test_update_a_task() {
        $task = Task::factory()->create();
        $this->patchJson(route('task.update', $task->id), ['title' => 'updated title'])
            ->assertOk();

        $this->assertDatabaseHas('tasks', ['title' => 'updated title']);
   }
}
