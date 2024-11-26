<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,user,donor',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('users')->with('success', 'User updated successfully.');
}



 // Method to update the user's role
 public function updateRole(Request $request, $id)
{
    // Validate the role input
    $request->validate([
        'role' => 'required|in:admin,user,donor',
    ]);

    // Find the admin by ID
    $user = User::findOrFail($id);

    // Update the role
    $user->role = $request->input('role');
    $user->save();

    // Redirect back to the users list with a success message
    return redirect()->route('users')->with('success', 'Role updated successfully!');
}

 // Make sure to import the User model at the top of your controller

public function store(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed', // password confirmation validation
        'role' => 'required|in:admin,user,donor', // Ensure the role is one of the valid options
    ]);

    // Create and save the new user in the 'users' table
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']), // Hash the password before saving
        'role' => $validated['role'], // Save the selected role
    ]);

    // Redirect to the users index page with a success message
    return redirect()->route('users')->with('success', 'User created successfully!');
}


//  public function destroy($id)
// {
//     // Find the user by ID and delete
//     $user = User::findOrFail($id);
//     $user->delete();

//     // Redirect back with a success message
//     return redirect()->route('users.index')->with('success', 'User deleted successfully');
// }


public function dashboard()
{
    $userCount = User::count(); // Fetch the total number of users
    return view('admin.dashboard', compact('userCount'));
}
public function destroy($id)
{
    User::findOrFail($id)->delete();
    return redirect()->route('users');
}


}


   
   


