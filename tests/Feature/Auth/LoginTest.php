<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_login() {
        $user = User::factory()->create();
        $response = $this->postJson(route('login.post'), [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertOk();
        
        $this->arrayHasKey('token', $response->json());
    }

    public function test_if_email_not_exists_in_database_return_error() {
        $this->postJson(route('login.post'), [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ])
            ->assertUnauthorized();
    }

    public function test_incorrect_password_gives_error() {
        $user = User::factory()->create();
        $this->postJson(route('login.post'), [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ])
            ->assertUnauthorized();
    }
}
