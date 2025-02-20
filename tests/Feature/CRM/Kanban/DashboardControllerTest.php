<?php

namespace Tests\Feature\CRM\Kanban;

use App\Models\Kanban\Dashboard;
use App\Models\Kanban\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardControllerTest extends TestCase
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
    public function it_can_access_the_dashboard_index(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/kanban/dashboards');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_dashboard(): void
    {
        $token = $this->getToken();
        $dashboard = Dashboard::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/kanban/dashboards/show/{$dashboard->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_dashboard(): void
    {
        $token = $this->getToken();

        $team = Team::factory()->create();
        $data = [
            'title' => 'Test Dashboard v-1' . now()->format('H:i:s'),
            'description' => 'Test Dashboard v-1' . now()->format('H:i:s'),
            'team_id' => $team->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/kanban/dashboards/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('dashboards', $data);
    }

    /** @test */
    public function it_can_update_an_existing_dashboard(): void
    {
        $token = $this->getToken();
        $dashboard = Dashboard::factory()->create();

        $data = [
            'title' => 'Test Dashboard update v-1' . now()->format('H:i:s'),
            'description' => 'Test Dashboard v-1' . now()->format('H:i:s'),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/kanban/dashboards/update/' . $dashboard->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('dashboards', $data);
    }

    /** @test */
    public function it_can_delete_a_dashboard(): void
    {
        $token = $this->getToken();
        $dashboard = Dashboard::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/kanban/dashboards/delete/' . $dashboard->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('dashboards', ['id' => $dashboard->id]);
    }
}
