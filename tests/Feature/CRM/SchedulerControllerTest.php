<?php

namespace Tests\Feature\CRM;

use App\Models\Scheduler;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SchedulerControllerTest extends TestCase
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

//    /** @test */
    public function it_can_access_the_scheduler_index(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/schedulers');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_scheduler(): void
    {
        $token = $this->getToken();
        $scheduler = Scheduler::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/schedulers/show/{$scheduler->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_scheduler(): void
    {
        $token = $this->getToken();

        $data = [
            'title' => $this->faker->word(),
            'label' => Scheduler::LABEL_PERSONAL,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'all_day' => $this->faker->boolean(),
            'event_url' => $this->faker->url(),
            'location' => $this->faker->word(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/schedulers/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('schedulers', $data);
    }

    /** @test */
    public function it_can_update_an_existing_scheduler(): void
    {
        $token = $this->getToken();
        $scheduler = Scheduler::factory()->create();

        $data = [
            'location' => $this->faker->word(),
            'description' => $this->faker->text(),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/schedulers/update/' . $scheduler->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('schedulers', $data);
    }

    /** @test */
    public function it_can_delete_a_scheduler(): void
    {
        $token = $this->getToken();
        $scheduler = Scheduler::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/schedulers/delete/' . $scheduler->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('schedulers', ['id' => $scheduler->id]);
    }
}
