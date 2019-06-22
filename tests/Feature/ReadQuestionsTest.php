<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadQuestionsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    function a_user_can_read_all_questions()
    {
        $question = factory('App\Question')->create([
            'user_id' => factory('App\User')->create()->id
        ]);

        $this->get('/questions')
             ->assertSee($question->title)
             ->assertSee(str_limit($question->title, 250));
    }


}
