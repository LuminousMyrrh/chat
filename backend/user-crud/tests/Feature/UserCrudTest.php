<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $data = [
            'name' => "TestName",
            'email' => "testmail@mail.com",
            'password' => "asthue",
        ];
        $response = $this->post('/api/users', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $data);
    }

    public function test_can_read_users()
    {
        $user = User::factory()->create();
        $response = $this->get('/api/users');

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $user->name]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Updated'];

        $response = $this->put("/api/users/{$user->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $data);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->delete("/api/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
