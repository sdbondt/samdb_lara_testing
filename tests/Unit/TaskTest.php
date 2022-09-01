<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    public function test_task_belongs_to_a_todolist() {
        $todolist = TodoList::factory()->create();
        $task = Task::factory()->create([
            'todolist_id' => $todolist->id
        ]);

        $this->assertInstanceOf(TodoList::class, $task->todolist);
    }
    
}
