<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class AuthTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $response = $this->post('/api/register', [
            'name'=>'Hanif Roihan',
            'email'=>'hanif@gmail.com',
            'password'=>'rahasia123!'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'access_token'
        ]);

        $this->assertDatabaseHas('users', [
            'email'=>'hanif@gmail.com',
            'name'=>'Hanif Roihan'
        ]);

    }

    public function testRegisterInvalid()
    {
        $response = $this->post('/api/register', [
            'name'=>'hanif',
            'email'=>'hanif',
            'password'=>'password'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }
}
