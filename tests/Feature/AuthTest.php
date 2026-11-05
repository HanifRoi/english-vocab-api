<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
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

    public function testLoginSuccess()
    {
        User::factory()->create([
            'name'=>'Hanif Roihan',
            'email'=>'hanif@test.com',
            'password'=>'rahasia123!'
        ]);

        $response = $this->post('/api/login', [
            'email'=>'hanif@test.com',
            'password'=>'rahasia1234!'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token'
        ]);
    }

    public function testLoginValidationError()
    {
        User::factory()->create([
            'name'=>'Hanif Roihan',
            'email'=>'hanif',
            'password'=>'email'
        ]);

        $response = $this->post('/api/login', [
            'email'=>'hanif',
            'password'=>''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function testLoginFailed()
    {
        User::factory()->create([
            'name'=>'Hanif Roihan',
            'email'=>'hanif@test.com',
            'password'=>'rahasia123!'
        ]);

        $response = $this->post('/api/login', [
            'email'=>'hanif@test.com',
            'password'=>'rahasia124!'
        ]);

        $response->assertStatus(401);
    }

    public function testLogout()
    {
       $user = User::factory()->create();
            //menggunakan Sanctum bukan $this->actingAs , 
            //berpura pura bahwa login menggunakan token API yang sah
            Sanctum::actingAs($user);
        $response = $this->post('/api/logout');
        $response->assertStatus(200);
    }
}
