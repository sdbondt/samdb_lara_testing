<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskCompletedTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function test_task_completed_status_can_be_toggled() {
        $task = Task::factory()->create();
        $this->patchJson(route('task.update', $task->id), ['completed' => !$task->completed]);

        $this->assertDatabaseHas('tasks', ['completed' => 1]);
    }
}
