<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index()
    {
        // Paginate users - this will get 10 users per page, you can adjust the number as needed
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('users.index', compact('users'));

    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));  // Assuming your create form is in resources/views/users/create.blade.php
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));  // Passing the user to the view
    }

    // Register method
    public function register(Request $request)
    {

        dd($request);
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();


        if ($user) {
            return redirect()->route('login');
        }
    }


    public function login(Request $request)
    {
        // Validate the incoming credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if a user is already logged in and log them out
        if (Auth::check()) {
            Auth::logout();
        }

        // Find the user by email
        $user = User::where('email', $credentials['email'])->first();

        // Verify user and password
        if ($user && Hash::check($request->password, $user->password)) {
            // Log the user in
            Auth::login($user);

            // Redirect to the intended page or dashboard
            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back!');
        }

        // Redirect back to login with error
        return redirect()
            ->route('login')
            ->with('error', 'Invalid credentials. Please try again.')
            ->withInput($request->only('email'));
    }

    public function dashboardPage()
    {
        if (Auth::check()) {
            return view('admin.Dashboard');
        } else {
            return redirect()->route('login');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required',
            'password' => 'nullable|string|min:8',
        ]);



        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        // Update password only if `change_password` is provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Hash the password
        }

        $user->save();


        return redirect()->route('users')->with('success', 'User updated successfully.');
    }



    // Method to update the user's role
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user,donor',
        ]);

        $user = User::findOrFail($id);

        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('users')->with('success', 'Role updated successfully!');
    }

    // Make sure to import the User model at the top of your controller

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // password confirmation validation
            'role' => 'required', // Ensure the role is one of the valid options
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $user->assignRole($request->role);



        // // Create and save the new user in the 'users' table
        // $user = User::create([
        //     'name' => $validated['name'],
        //     'email' => $validated['email'],
        //     'password' => bcrypt($validated['password']), // Hash the password before saving
        //     'role_id' => $validated['role_id'], // Save the selected role
        // ]);

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
    


//change password

public function ChangePasswordForm(){
    return view('changepassword');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|confirmed|min:6',
    ]);

    $auth = Auth::user();

    if (!Hash::check($request->current_password, $auth->password)) {
        return back()->withErrors(['current_password' => 'Current Password is Invalid'])
                     ->withInput();
    }

    if ($request->current_password === $request->new_password) {
        return back()->withErrors(['new_password' => 'New Password cannot be the same as your current password.'])
                     ->withInput();
    }

    $user = User::find($auth->id);
    $user->password = Hash::make($request->new_password);  // Hash new password before saving
    $user->save();

    return redirect()->route('dashboard')->with('success', 'Password Changed Successfully');
}



//update Profile

public function UpdateProfileForm()
{
    
    $user = Auth::user();
    
    $fullName = $user->first_name . ' ' . $user->last_name;

    return view('updateprofile', compact('user', 'fullName'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    if (!Auth::check()) {
        return redirect()->route('login')->withErrors(['error' => 'Unauthorized access. Please log in.']);
    }
    $user = User::find(Auth::id());

    if (!$user) {
        return redirect()->route('dashboard')->withErrors(['error' => 'User not found.']);
    }

    // Split full name into first_name and last_name
    $nameParts = explode(' ', $request->full_name, 2);
    $user->first_name = $nameParts[0] ?? '';
    $user->last_name = $nameParts[1] ?? null; // Use null instead of an empty string

    $user->email = $request->email;

    // Handle profile photo upload if provided
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');

        if (!$file->isValid()) {
            return back()->withErrors(['profile_photo' => 'Invalid image file.']);
        }

        // Create a unique name for the image
        $uniqueName = uniqid() . '.' . $file->getClientOriginalExtension();
        
        $destinationPath = public_path('uploads/profile_photos');
        
        // Move the uploaded file to the destination
        $file->move($destinationPath, $uniqueName);
        
        // Save the image name in the database
        $user->profile_photo = 'uploads/profile_photos/' . $uniqueName;
    }
    $user->save();
    return redirect()->route('dashboard')->with('success', 'Profile Updated Successfully');
}





    public function dashboard()
    {
        if (auth::check()) {
            $userCount = User::count(); // Fetch the total number of users
            return view('admin.dashboard', compact('userCount'));
        } else {
            return redirect()->route('login');
        }

    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users');
    }


}






