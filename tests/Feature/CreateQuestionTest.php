<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateQuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_may_not_create_questions()
    {
        $this->post('/questions', ['title' => 'title', 'body' => 'body'])
             ->assertRedirect('/login');
    }

    /** @test */
    function guests_may_not_update_questions()
    {
        $question = create('App\Question', ['user_id' => create('App\User')->id]);
        $this->put("/questions/{$question->id}", ['title' => 'title', 'body' => 'body'])
             ->assertRedirect('/login');
    }

    /** @test */
    function guests_may_not_delete_questions()
    {
        $question = create('App\Question', ['user_id' => create('App\User')->id]);
        $this->delete("/questions/{$question->id}")
             ->assertRedirect('/login');
    }

    /** @test */
    function a_question_requires_a_body()
    {
        $this->signIn();
        $this->post('/questions', ['title' => 'title'])
             ->assertSessionHasErrors('body');
    }


    /** @test */
    function a_question_requires_a_title()
    {
        $this->signIn();
        $this->post('/questions', ['body' => 'body'])
             ->assertSessionHasErrors('title');
    }

    /** @test */
    function an_authenticated_user_can_create_questions()
    {
        $this->signIn();
        $attributes = [
            'title' => 'question title',
            'body'  => 'question body'
        ];
        $this->post('/questions', $attributes);

        $this->assertDatabaseHas('questions', $attributes);
    }

    /** @test */
    function an_authenticated_user_may_update_questions()
    {
        $this->signIn();
        $attributes = [
            'title' => 'new title',
            'body'  => 'new body',
        ];

        $question = create('App\Question', ['user_id' => auth()->id()]);
        $this->put("/questions/{$question->id}", $attributes);

        $this->assertDatabaseHas('questions', $attributes);
    }

    /** @test */
    function an_authenticated_user_may_delete_questions()
    {
        $this->signIn();
        $question = create('App\Question', [
            'user_id' => auth()->id(),
            'answers_count' => 0,
            'title'   => 'question title']);
        $this->delete("/questions/{$question->id}");
        $this->assertDatabaseMissing('questions', ['title' => 'question title']);
    }

    /** @test */
    function a_user_can_edit_or_delete_his_question_only()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => create('App\User')->id]);
        $uri = '/questions/' . $question->id;

        $this->get($uri . '/edit')
             ->assertStatus(403);

        $this->put($uri, ['title' => 'new title', 'body' => 'new body'])
             ->assertStatus(403);

        $this->delete($uri)
             ->assertStatus(403);
    }
}