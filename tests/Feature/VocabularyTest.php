<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class VocabularyTest extends TestCase
{
    public function testIndex()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->get('/api/vocabularies')->assertStatus(200);
    }

}
