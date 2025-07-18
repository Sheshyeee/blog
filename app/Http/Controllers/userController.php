<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post\userPosts;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class userController extends Controller
{
    use AuthorizesRequests;

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('showblog')->with('success', 'Logged in successfully!');
            } else {
                return redirect()->route('showblog')->with('success', 'Logged in successfully!');
            }
        }
        return redirect('/login')->with('error', 'The provided credentials do not match our records.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully!');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit_user', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required',
        ]);

        $user->update($validated);

        return redirect()->route('allUsers.show')->with('success', 'Updated successfully!');
    }


    public function showRole()
    {
        return view('role');
    }

    public function allUser()
    {
        $this->authorize('all-users');
        $users = User::paginate(11);
        return view('all_user', ['users' => $users]);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        Session::put('selected_role', $request->role);

        return redirect('/register')->with('success', 'Role selected successfull');
    }

    public function showRegister()
    {
        $role = Session::get('selected_role');

        if (!$role) {
            return redirect('/role')->with('error', 'Please select a role first.');
        }

        return view('register', ['role' => $role]);
    }

    public function register(Request $request)
    {
        $role = Session::get('selected_role');

        if (!$role) {
            return redirect('/role')->with('error', 'Role not set in session.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        $validated['role'] = $role;
        $validated['password'] = bcrypt($validated['password']);

        // Save the user and get the instance
        $user = User::create($validated);

        // Send email verification
        $user->sendEmailVerificationNotification();

        // Auto-login
        Auth::login($user);

        // Clear session role
        Session::forget('selected_role');

        return redirect()->route('verification.notice')->with('success', 'User created successfully! Please verify your email.');
    }


    public function destroy($id)
    {

        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('allUsers.show')->with('success', 'User deleted successfully.');
    }
}
