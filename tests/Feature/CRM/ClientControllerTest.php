<?php

namespace Tests\Feature\CRM;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Contact;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientControllerTest extends TestCase
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
    public function it_can_access_the_client_index(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/clients');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_client(): void
    {
        $token = $this->getToken();
        $contact = Client::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/clients/show/{$contact->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_client(): void
    {
        $token = $this->getToken();

        $data = [
            'client_type_id' => ClientType::factory()->create()->id,
            'status' => $this->faker->word(),
            'notes' => $this->faker->word(),
            'worker_id' => Worker::factory()->create()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'contact_id' => Contact::factory()->create()->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/clients/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', $data);
    }

    /** @test */
    public function it_can_update_an_existing_client(): void
    {
        $token = $this->getToken();
        $client = Client::factory()->create();

        $data = [
            'status' => $this->faker->word(),
            'notes' => $this->faker->word(),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/clients/update/' . $client->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', $data);
    }

    /** @test */
    public function it_can_delete_a_client(): void
    {
        $token = $this->getToken();
        $client = Client::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/clients/delete/' . $client->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
