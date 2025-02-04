<?php

namespace Tests\Feature\CRM;

use App\Models\CommunicationType;
use App\Models\Contact;
use App\Models\ContactInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactInformationControllerTest extends TestCase
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
    public function it_can_access_the_get_communication_type(): void
    {
        $token = $this->getToken();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/v1/crm/communications/types');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_set_a_new_information_contact(): void
    {
        $token = $this->getToken();

        $data = [
            'contact_id' => Contact::factory()->create()->id,
            'communication_type_id' => CommunicationType::factory()->create()->id,
            'value' => CommunicationType::$getTypes[$this->faker->numberBetween(0, 8)],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/v1/crm/contacts/information/set', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('contact_information', $data);
    }

    /** @test */
    public function it_can_update_an_existing_information_contact(): void
    {
        $token = $this->getToken();
        $contactInformation = ContactInformation::factory()->create();

        $data = [
            'value' => CommunicationType::$getTypes[$this->faker->numberBetween(0, 8)],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/v1/crm/contacts/information/update/' . $contactInformation->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('contact_information', $data);
    }

    /** @test */
    public function it_can_delete_a_contact(): void
    {
        $token = $this->getToken();
        $contactInformation = ContactInformation::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/v1/crm/contacts/information/delete/' . $contactInformation->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('contact_information', ['id' => $contactInformation->id]);
    }
}
