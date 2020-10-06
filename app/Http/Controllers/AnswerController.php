<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Answer;
use Auth;
use App\Notifications\AnswerQuestionNotification;


class AnswerController extends Controller
{
    public function store(AnswerRequest $request, $questionId)
	{
	    $answer = Answer::updateOrCreate([
	        'question_id'=>$questionId,
	        'user_id' => Auth::id()],
	        ['content'=>$request->get('content')]);
	        
	    //通知
    	$answer->question->user->notify(new AnswerQuestionNotification($answer));

	    return back();
	}
}
