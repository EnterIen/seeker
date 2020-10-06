<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id=null)
    {
        
        $id ?? $id = Auth::id();
        $user = User::findOrFail($id);

        return view('user.show',compact('user'));
    }
}