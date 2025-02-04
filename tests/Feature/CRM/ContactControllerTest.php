<?php

namespace Tests\Feature\CRM;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactControllerTest extends TestCase
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
    public function it_can_access_the_contact_index(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/contacts');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_specific_contact(): void
    {
        $token = $this->getToken();
        $contact = Contact::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get("/api/v1/crm/contacts/show/{$contact->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_contact(): void
    {
        $token = $this->getToken();

        $data = [
            'surname' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'patronymic' => $this->faker->lastName(),
            'date_birth' => $this->faker->date(),
            'address' => $this->faker->address(),
            'place_work' => $this->faker->company(),
            'job_position' => $this->faker->jobTitle(),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/contacts/create', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('contacts', $data);
    }

    /** @test */
    public function it_can_update_an_existing_contact(): void
    {
        $token = $this->getToken();
        $contact = Contact::factory()->create();

        $data = [
            'address' => $this->faker->address(),
            'job_position' => $this->faker->jobTitle(),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/contacts/update/' . $contact->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('contacts', $data);
    }

    /** @test */
    public function it_can_delete_a_contact(): void
    {
        $token = $this->getToken();
        $contact = Contact::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/contacts/delete/' . $contact->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}

