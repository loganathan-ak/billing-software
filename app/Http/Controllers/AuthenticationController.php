<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
    
        // Get the GST number from the first admin user
        $admin = User::where('user_role', 'admin')->first();
        $gst = $admin ? $admin->gst_number : null; // Fallback to null if no admin found
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gst_number' => $gst,
        ]);
    
        Auth::login($user);
    
        return redirect()->route('home');
    }
    

    public function login(Request $request){

        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // Prevent session fixation
        return redirect()->route('home');
    }

    return redirect()->route('login')->with('error', 'Invalid credentials. Please try again.');

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
 
        return redirect('login');
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'company_name' => 'nullable|string',
            'address' => 'nullable|string',
            'gst_number' => 'nullable|string',
        ]);
    
        $user = Auth::user(); // currently logged in user
    
        if ($user->user_role === 'admin') {
            $gst = $validated['gst_number'];
    
            // Update GST for all users
            User::query()->update(['gst_number' => $gst]);
        } else {
            // If not admin, get GST from admin
            $admin = User::where('user_role', 'admin')->first();
            $gst = $admin ? $admin->gst_number : null;
        }
    
        // Update current user profile
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->contact_number = $validated['phone'];
        $user->company_name = $validated['company_name'];
        $user->address = $validated['address'];
        $user->gst_number = $gst;
    
        $user->save();
    
        return redirect()->route('userprofile')->with('access', 'Profile updated successfully.');
    }

    public function editUser($id)
{
    // Retrieve the user by ID
    $user = User::findOrFail($id);

    return view('employees.edit-user', compact('user'));
}
    
public function updateUser(Request $request, $id)
{
    // Validate the inputs
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|min:6',  // Password is optional but should be at least 8 characters
    ]);

    // Retrieve the user by ID
    $user = User::findOrFail($id);

    // Update the name
    $user->name = $request->name;

    // Update the password if it's provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Save the updated user data
    $user->save();

    // Redirect back with a success message
    return redirect('/employees')->with('updated', 'User updated successfully.');
}


public function addUserForm(){
    return view('employees.add-user');
}

public function addUser(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'required|string|min:6',
    ]);

    // Create user with only name, password, and role
    User::create([
        'name' => $request->name,
        'password' => Hash::make($request->password),
        'user_role' => 'employee',
    ]);

    return redirect('/employees')->with('success', 'User added successfully.');
}


}
