<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_you_can_register() {
        $response = $this->postJson(route('signup.post'), [
            'email' => 'test@gmail.com',
            'name' => 'test',
            'password' => 'test'
        ])
            ->assertOk();

        $this->assertDatabaseHas('users', ['email' => 'test@gmail.com']);
        $this->arrayHasKey('token', $response->json());
    }
}
