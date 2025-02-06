<?php

namespace Tests\Feature\CRM;

use App\Models\Client;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class DealControllerTest extends TestCase
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
    public function get_all_deals_from_client(): void
    {
        $token = $this->getToken();
        $client = Client::factory()->create();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/deals/clients/' . $client->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_deal_index(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/deals');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_deal(): void
    {
        $token = $this->getToken();
        $deal = Deal::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/deals/show/{$deal->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_deal(): void
    {
        $token = $this->getToken();

        $data = [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'status' => Deal::$statuses[rand(0, 5)],
            'amount' => 421,
            'stage' => Deal::$stages[rand(0, 5)],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'client_id' => Client::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/deals/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('deals', $data);
    }

    /** @test */
    public function it_can_update_an_existing_deal(): void
    {
        $token = $this->getToken();
        $deal = Deal::factory()->create();

        $data = [
            'status' => Deal::$statuses[rand(0, 5)],
            'amount' => 213,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/deals/update/' . $deal->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('deals', $data);
    }

    /** @test */
    public function it_can_delete_a_deal(): void
    {
        $token = $this->getToken();
        $deal = Deal::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/deals/delete/' . $deal->id);
        $response->assertStatus(200);
        $this->assertSoftDeleted('deals', ['id' => $deal->id]);
    }
}
