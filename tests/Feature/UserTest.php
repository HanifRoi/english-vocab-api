<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testShowCurrentUser()
    {
        $userA =  User::factory()->create([
            'name'=>'Hanif',
            'email'=>'hanif@gmail.com',
            'password'=>Hash::make('rahasia123!')
        ]);
        $userB =  User::factory()->create([
            'name'=>'Roihan',
            'email'=>'roihan@gmail.com',
            'password'=>Hash::make('rahasia234!')
        ]);
        Sanctum::actingAs($userA);
        $this->get('/api/user')
        ->assertStatus(200)
        ->assertSeeText('Hanif')
        ->assertDontSeeText('Roihan');
    }

    public function testUpdateSuccess()
    {
        $userA =  User::factory()->create([
            'name'=>'Hanif',
            'email'=>'hanif@gmail.com',
            'password'=>Hash::make('rahasia123!')
        ]);

        Sanctum::actingAs($userA);
        $this->put('/api/user', [
            'name'=>'Hanif Ganteng',
            'email'=>'hanif@gmail.com',
            'password'=>''
        ])->assertStatus(200);
    }

    public function testUpdateError()
    {
        $userA =  User::factory()->create([
            'name'=>'Hanif',
            'email'=>'hanif@gmail.com',
            'password'=>Hash::make('rahasia123!')
        ]);

        Sanctum::actingAs($userA);
        $this->put('/api/user', [
            'name'=>'Hanif Ganteng',
            'email'=>'',
            'password'=>'asdfasfs'
        ])->assertStatus(422)->assertJsonValidationErrors(['email', 'password']);
    }
}
