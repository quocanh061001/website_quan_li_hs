<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenController extends Controller
{
    public function index(){
        return view('authentication.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
         $remember = $request->remember;
         if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            if($request->input('email') == 'admin@laravel.com'){
                return redirect()->intended('dashboard');
            }else{
                return redirect()->intended('dashboardClass');

            }
        }
        return redirect()->back()->withErrors(['email' => 'Invalid Credentials!']);
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function registration(){
        $teachers = DB::table('giaovien')->where('state', 1)->get();
       return view('authentication.register', [
           'teachers'=>$teachers
       ]);
    }

    public function register(Request $request){
         $request->validate([
            'username'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5',
            'role'=>'required'
         ]);
         $user = new User();
         $user->name = $request->username;
         $user->email = $request->email;
         $user->password = Hash::make($request->password);
         $user->teacher_id = $request->gvcn;
         $user->role = $request->role;
         $res = $user->save();
         if($res){
            return back()->with('success', 'you have registered successfully');
         }else{
            return back()->with('fail', 'something wrong');
         }
    }

}
