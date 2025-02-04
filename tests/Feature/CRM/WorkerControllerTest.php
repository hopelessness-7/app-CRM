<?php

namespace Tests\Feature\CRM;

use App\Models\Company;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class WorkerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
    public function it_can_access_the_worker_index(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/workers');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_worker(): void
    {
        $token = $this->getToken();
        $worker = Worker::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/workers/show/{$worker->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_worker(): void
    {
        $token = $this->getToken();

        $data = [
            'user_id' => User::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/workers/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('workers', $data);
    }

    /** @test */
    public function it_can_update_an_existing_worker(): void
    {
        $token = $this->getToken();
        $worker = Worker::factory()->create();

        $data = [
            'company_id' => Company::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/workers/update/' . $worker->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('workers', $data);
    }

    /** @test */
    public function it_can_delete_a_worker(): void
    {
        $token = $this->getToken();
        $worker = Worker::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/workers/delete/' . $worker->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('workers', ['id' => $worker->id]);
    }
}
