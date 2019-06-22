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
    function a_question_requires_a_body()
    {
        $this->signIn();
        $this->post('/questions',['title' => 'title'])
            ->assertSessionHasErrors('body');
    }


    /** @test */
    function a_question_requires_a_title()
    {
        $this->signIn();
        $this->post('/questions',['body' => 'body'])
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
}