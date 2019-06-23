<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAnswerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_create_an_answer()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);

        $this->post(route('questions.answers.store', [$question->id]), [
            'body' => 'answer body'
        ]);

        $this->assertEquals(1, $question->fresh()->answers()->count());
        $this->assertDatabaseHas('answers', ['body' => 'answer body']);
    }

    /** @test */
    function a_user_can_update_his_answer()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);
        $answer = create('App\Answer', ['user_id' => auth()->id(), 'question_id' => $question->id]);

        $this->put("/questions/{$question->id}/answers/{$answer->id}", [
            'body' => 'body changed'
        ]);

        $this->assertDatabaseHas('answers', ['body' => 'body changed']);
    }

    /** @test */
    function a_user_can_only_update_his_question()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);
        $another_answer = create('App\Answer', [
            'user_id'     => create('App\User')->id,
            'question_id' => $question->id
        ]);

        $this->put("/questions/{$question->id}/answers/{$another_answer->id}", [
            'body' => 'body changed'
        ])->assertStatus(403);
    }


}