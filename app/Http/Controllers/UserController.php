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
            return response()->json(['message' => 'Login Successful'], 200);  // Redirect to dashboard after successful login
            // return redirect()->route('admin.dashboard')->with('success', 'Login Successfull !');
        }

        // Check email exist (for invalid usename)
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid username'], 400);
        } else {
            return response()->json(['message' => 'Invalid password'], 401);
        }
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
        return redirect()->route('login');

    }

}
