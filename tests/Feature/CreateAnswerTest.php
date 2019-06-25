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

    /** @test */
    function when_answer_is_created_the_answers_count_column_in_questions_should_increase()
    {
        $this->signIn();
        $question = create('App\Question');
        $answer = create('App\Answer', [
            'question_id' => $question->id
        ]);

        $this->assertEquals(1, $question->fresh()->answers_count);
    }

    /** @test */
    function when_answer_is_deleted_if_its_the_best_answer_the_best_answer_id_column_in_question_should_set_to_null()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);
        $answer = create('App\Answer', [
            'user_id'     => auth()->id(),
            'question_id' => $question->id
        ]);
        $question->best_answer_id = $answer->id;
        $question->save();

        $this->delete("/questions/{$question->id}/answers/{$answer->id}");
        $this->assertNull($question->fresh()->best_answer_id);
    }

    /** @test */
    function when_an_answer_is_selected_as_best_answer_questions_best_answer_id_should_equal_answer_id()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);
        $answer = create('App\Answer', [
            'user_id'     => auth()->id(),
            'question_id' => $question->id
        ]);
        $this->post(route('answers.accept', $answer->id));
        $this->assertEquals($answer->id, $question->fresh()->best_answer_id);
    }

    /** @test */
    function the_user_who_created_a_question_can_only_choose_the_best_answer()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => create('App\User')->id]);
        $answer = create('App\Answer', [
            'user_id'     => create('App\User')->id,
            'question_id' => $question->id
        ]);

        $this->post(route('answers.accept', $answer->id));
        $this->assertNull($question->fresh()->best_answer_id);
    }


}