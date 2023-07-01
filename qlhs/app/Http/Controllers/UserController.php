<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        return view('Users.index');
    }

    public function fetch_user(){
        $users = User::all();
        return response()->json([
            'users'=>$users,
        ]
        );
    }
}
