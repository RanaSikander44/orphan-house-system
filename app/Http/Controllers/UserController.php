<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Register method
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($data);

        if ($user) {
            return redirect()->route('login');
        }
    }

    public function login(Request $request)
    {
        // Validate login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Attempt login
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.Dashboard');  // Redirect to dashboard after successful login
        }
    
        // If login fails, redirect back with an error message
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    

    public function dashboardPage()
    {
        if (Auth::check()) {
            return view('admin.Dashboard'); // This is the correct path to the admin dashboard view
        } else {
            return redirect()->route('login');
        }
    }

    
    public function logout()
    {
         Auth::logout();
            return view('login');         
        
    }
    
}
