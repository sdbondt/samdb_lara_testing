<?php

namespace Tests\Feature;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->todolist = TodoList::factory()->create([
            'user_id' => $user->id
        ]);
    }

    public function test_fetch_todolists()
    {
        TodoList::factory()->create();
        $response = $this->getJson(route('todolist.index'));
        $this->assertEquals(1, count($response->json()));
    }

    public function test_fetch_single_todolist() {
        $response = $this->getJson(route('todolist.show', $this->todolist->id))
            ->assertOk()
            ->json();

        $this->assertEquals($response['name'], $this->todolist->name);
    }

    public function test_store_todolist() {
        $todolist = TodoList::factory()->make([
            'name' => 'test store route'
        ]);
        $response = $this->postJson(route('todolist.store'), ['name' => $todolist->name])
            ->assertCreated()
            ->json();

        $this->assertEquals($response['name'], $todolist->name);
        $this->assertDatabaseHas('todo_lists', ['name' => $todolist->name]);
    }

    public function test_name_field_required_while_storing_todolist() {
        $this->withExceptionHandling();
         $this->postJson(route('todolist.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_delete_todolist() {
        $this->deleteJson(route('todolist.delete', $this->todolist->id));

        $this->assertDatabaseMissing('todo_lists', ['name' => $this->todolist->name]);
    }

    public function test_patch_todolist() {
        $this->patchJson(route('todolist.update', $this->todolist->id), ['name' => 'updated name'])
            ->assertOk();

        $this->assertDatabaseHas('todo_lists', ['id' => $this->todolist->id, 'name' => 'updated name']);
    }

    public function test_name_field_required_while_updating_todolists() {
        $this->withExceptionHandling();
        $this->patchJson(route('todolist.update', $this->todolist->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
