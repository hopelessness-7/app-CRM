<?php

namespace Tests\Feature\Kanban;

use App\Models\Kanban\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeamControllerTest extends TestCase
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
    public function it_can_access_the_team_index(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/kanban/teams');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_team(): void
    {
        $token = $this->getToken();
        $team = Team::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/kanban/teams/show/{$team->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_team(): void
    {
        $token = $this->getToken();

        $data = [
            'title' => 'Test Team v-1' . now()->format('H:i:s'),
            'description' => 'Test Team v-1' . now()->format('H:i:s'),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/kanban/teams/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('teams', $data);
    }

    /** @test */
    public function it_can_update_an_existing_team(): void
    {
        $token = $this->getToken();
        $team = Team::factory()->create();

        $data = [
            'title' => 'Test Team update v-1' . now()->format('H:i:s'),
            'description' => 'Test Team update v-1' . now()->format('H:i:s'),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/kanban/teams/update/' . $team->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('teams', $data);
    }

    /** @test */
    public function it_can_delete_a_team(): void
    {
        $token = $this->getToken();
        $team = Team::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/kanban/teams/delete/' . $team->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}

