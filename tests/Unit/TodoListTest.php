<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_todolist_can_have_many_tasks() {
        $todolist = TodoList::factory()->create();
        $task = Task::factory()->create([
            'todolist_id' => $todolist->id
        ]);

        $this->assertInstanceOf(Task::class, $todolist->tasks->first());
    }

    public function test_if_todolist_is_deleted_all_its_tasks_get_deleted() {
        $todolist = TodoList::factory()->create();
        $task = Task::factory()->create([
            'todolist_id' => $todolist->id,
        ]);
        $task2 = Task::factory()->create();

        $todolist->delete();

        $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertDatabaseHas('tasks', ['id' => $task2->id]);
    }
}
