<?php

namespace Tests\Feature\CRM\Kanban;

use App\Models\Client;
use App\Models\Kanban\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function getToken(): string
    {
        $this->assertEquals('testing', env('APP_ENV'));
        $user = User::factory()->create();
        return JWTAuth::fromUser($user);
    }


    /** @test */
    public function it_can_set_a_new_tasks_clients(): void
    {
        $token = $this->getToken();

        $data = [
            'task_id' => Task::factory()->create()->id,
            'client_id' => Client::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/kanban/tasks/clients/set', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('client_tasks', $data);
    }

    /** @test */
    public function it_can_delete_a_tasks_clients(): void
    {
        $token = $this->getToken();

        $data = [
            'task_id' => Task::factory()->create()->id,
            'client_id' => Client::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post("/api/v1/crm/kanban/tasks/clients/delete", $data);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('client_tasks', $data);
    }

}
