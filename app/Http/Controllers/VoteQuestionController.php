<?php

namespace App\Http\Controllers;

use App\Question;

class VoteQuestionController extends Controller
{

    /**
     * VoteQuestionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
        $vote = (int)request()->vote;
        auth()->user()->voteQuestion($question, $vote);
        return back();
    }


}
