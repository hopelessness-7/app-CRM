<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    public function testBasic()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
