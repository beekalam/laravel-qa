<?php

namespace Tests\Unit;

use App\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QeustionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_have_questions()
    {
        $user = create('App\User');
        $question = create('App\Question', ['user_id' => $user->id]);

        $this->assertInstanceOf(Question::class, $user->questions->first());

    }
}