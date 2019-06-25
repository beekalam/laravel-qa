<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_may_not_favorite_questions()
    {
        $this->post("/questions/1/favorites")
             ->assertRedirect('/login');
    }

    /** @test */
    function a_user_can_favorite_a_question()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);
        $this->post("/questions/{$question->id}/favorites");
        $this->assertDatabaseHas('favorites', [
            'user_id'     => auth()->id(),
            'question_id' => $question->id
        ]);
    }

    /** @test */
    function a_user_can_unfavorite_a_question()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);
        $this->delete("/questions/{$question->id}/favorites");
        $this->assertDatabaseMissing('favorites', [
            'user_id'     => auth()->id(),
            'question_id' => $question->id
        ]);
    }


}