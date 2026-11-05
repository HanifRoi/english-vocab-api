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

    public function testStoreSuccess()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->post('/api/vocabularies', [
            'word'=>'what',
            'meaning'=>'apa',
            'part_of_speech'=>'',
            'example'=>'what is that?',
            'is_mastered'=>true
        ])->assertStatus(201);
    }

    public function testStoreInvalid()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->post('/api/vocabularies', [
            'word'=>'',
            'meaning'=>'',
            'part_of_speech'=>'',
            'example'=>'what is that?',
            'is_mastered'=>true
        ])->assertStatus(422)->assertJsonValidationErrors(['word', 'meaning']);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $vocab = $user->vocabularies()->create([
            'word'=>'yes',
            'meaning'=>'ya'
        ]);

        $this->get('/api/vocabularies/' . $vocab->id)->assertStatus(200);
    }

    public function testShowUserACannotSeeVocabUserB()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $vocabB = $userB
        ->vocabularies()
        ->create([
            'word'=>'do not',
            'meaning'=>'jangan'
        ]);

        Sanctum::actingAs($userA);
        $this->get('/api/vocabularies/'. $vocabB->id)->assertStatus(403);
    }

}
