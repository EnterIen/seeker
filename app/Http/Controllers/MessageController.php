<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use App\User;
use App\Notifications\SendMessageNotification;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 发送私信
     * 
     * @param CommentRequest request
     * @return redirect back
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->get('to_user_id'),
            'content' => $request->get('content')
        ]);

        //通知
    	$message->toUser->notify(new SendMessageNotification());

        return back();
    }

    /**
     * 读取私信
     *
     * @param int id
     * @return view show
     */
    public function show($id)
    {
    	if ($id === Auth::id()) {
    		$messages = Message::where(function($q) use ($id) {
	            $q->where(['from_user_id'=>$id]);
	        })->orWhere(function($q) use ($id) {
	            $q->where(['to_user_id'=>$id]);
	        })->get();
    	} else {
    		$messages = Message::where(function($q) use ($id) {
	            $q->where(['from_user_id'=>$id,'to_user_id'=>Auth::id()]);
	        })->orWhere(function($q) use ($id) {
	            $q->where(['from_user_id'=>Auth::id(),'to_user_id'=>$id]);
	        })->get();
    	}

        return view('message.show',compact('messages'),['to_user_id'=>$id]);
    }
}