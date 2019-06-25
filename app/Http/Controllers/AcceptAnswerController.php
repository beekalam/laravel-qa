<?php

namespace App\Http\Controllers;

use App\Answer;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);
        $answer->question->AcceptBestAnswer($answer);
        return back();
    }
}
