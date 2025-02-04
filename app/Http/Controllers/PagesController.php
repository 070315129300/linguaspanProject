<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class PagesController extends Controller
{
    public function index(){
        return view('index');
    }
    public function login(){
        return view('auth/login');
    }
    public function userlogin(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Attempt to retrieve the user by email
        $user = User::where('email', $request->email)->first();
        // Check if the user exists
        if (!$user) {
            return back()->with('fail', 'This email is not registered');
        }
        // Check if the provided password matches the hashed password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('fail', 'Password mismatch');
        }
        // Log the user in
        Auth::login($user);

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->route('admindashboard'); // Redirect to admin dashboard
        } else {
            return redirect()->route('index'); // Redirect to index for regular users
        }
    }

    public function resetpassword(){
        return view('auth/reset-password');
    }
    public function forgetpassword(){
        return view('auth/forgot-password');
    }
    public function contribute(){
        return view('contribute');
    }
    public function listen(){
        return view('listen');
    }
    public function review(){
        return view('review');
    }
    public function write(){
        return view('write');
    }
    public function language(){
        return view('languages');
    }
    public function dataCollection(){
        return view('data_collection');
    }
    public function about(){
        return view('about');
    }
    public function stats(){
        return view('stats');
    }
//    public function profiles(){
//
//        return view('profile');
//    }
    public function profiles()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('profile', ['user' => $user]);
        }
        return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
    }
    public function changeinfo(){
        if (Auth::check()) {
            $user = Auth::user();
            return view('change_info', ['user' => $user]);
        }
        return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
    }
    public function delete_profile(){
        if (Auth::check()) {
            $user = Auth::user();
            return view('delete_profile', ['user' => $user]);
        }
        return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
    }
    public function download(){
        return view('download_data');
    }

}
