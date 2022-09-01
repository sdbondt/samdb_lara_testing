<?php

namespace Tests\Unit;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_todolists() {
        $user = User::factory()->create();
        TodoList::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(TodoList::class, $user->todolists->first());
    }
}
