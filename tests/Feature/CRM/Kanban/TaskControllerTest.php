<?php

namespace Tests\Feature\CRM\Kanban;

use App\Models\Kanban\Dashboard;
use App\Models\Kanban\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Получить JWT-токен для аутентификации.
     *
     * @return string
     */
    protected function getToken(): string
    {
        $this->assertEquals('testing', env('APP_ENV'));
        $user = User::factory()->create();
        return JWTAuth::fromUser($user);
    }

    /** @test */
    public function it_can_access_the_task_index(): void
    {
        $token = $this->getToken();
        $dashboard = Dashboard::factory()->create();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/kanban/tasks/' . $dashboard->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_task(): void
    {
        $token = $this->getToken();
        $task = Task::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/kanban/tasks/show/{$task->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_task(): void
    {
        $token = $this->getToken();

        $data = [
            'name' => 'Test task v1',
            'description' => 'Test task v1',
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addHours(2)->format('Y-m-d H:i:s'),
            'hashtags' => ['test', 'feature_test'],
            'dashboard_id' => Dashboard::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/kanban/tasks/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', Arr::except($data, ['hashtags']));

    }

    /** @test */
    public function it_can_update_an_existing_task(): void
    {
        $token = $this->getToken();
        $task = Task::factory()->create();

        $data = [
            'name' => 'Test Task update v-1' . now()->format('H:i:s'),
            'description' => 'Test task update v-1' . now()->format('H:i:s'),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/kanban/tasks/update/' . $task->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function it_can_delete_a_task(): void
    {
        $token = $this->getToken();
        $task = Task::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/kanban/tasks/delete/' . $task->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
