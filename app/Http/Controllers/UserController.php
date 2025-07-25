<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index (Request $request) {
        $query = User::with('department');
        
        // Check if current user is HOD and restrict to their department
        $currentUser = auth()->user();
        
        // Filter departments based on user role
        if ($currentUser->position === 'HOD' && $currentUser->department_id) {
            $departments = Department::where('id', $currentUser->department_id)->get();
            $query->where('department_id', $currentUser->department_id);
        } else {
            $departments = Department::all();
        }

        if ($request->filled('department_filter')) {
            $query->whereHas('department', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->department_filter . '%');
            });
        }

        $users = $query->get();

        return view('user', compact('users', 'departments'));
    }

    public function store (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'position' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'position' => $validated['position'],
            'department_id' => $validated['department_id'],
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function create () {
        $departments = Department::all();
        return view('userForm', compact('departments'));
    }

    public function edit ($id) {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();
        
        // Check if current user has permission to edit this user
        if ($currentUser->position !== 'Admin System' && 
            !($currentUser->position === 'HOD' && $currentUser->department_id === $user->department_id)) {
            abort(403, 'Unauthorized action.');
        }
        
        $departments = Department::all();

        return view ('editUser', compact('user', 'departments'));
    }

    public function update (Request $request, $id) {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();
        
        // Check if current user has permission to update this user
        if ($currentUser->position !== 'Admin System' && 
            !($currentUser->position === 'HOD' && $currentUser->department_id === $user->department_id)) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
            'position' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'password' => 'required|string|min:8',
        ]);

        $user->update($validated);

        return redirect()->route('user')->with('success', 'User data updated successfully!');
    }

    public function destroy ($id) {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();
        
        // Only Admin System can delete users
        if ($currentUser->position !== 'Admin System') {
            abort(403, 'Unauthorized action.');
        }
        
        $user->delete();

        return redirect()->route('user')->with('success', 'User deleted successfully!');
    }

    public function impersonate(User $user)
    {
        // Check if the current user is an IT Admin
        if (auth()->user()->department->name !== 'Information Technology' || auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        // Store the original user's ID in the session
        session()->put('impersonator_id', auth()->id());

        // Login as the target user
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'You are now impersonating ' . $user->name);
    }

    public function stopImpersonating()
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        // Get the original user
        $originalUser = User::find(session()->get('impersonator_id'));

        // Clear the impersonation session
        session()->forget('impersonator_id');

        // Login as the original user
        Auth::login($originalUser);

        return redirect()->route('dashboard')->with('success', 'Stopped impersonating user');
    }
}
