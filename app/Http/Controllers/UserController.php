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
        
        // Check if user is from Finance (4) or Human Resources (3) - they have full access
        $hasFullAccess = $currentUser->role === 'Admin System' || 
                        $currentUser->department_id === 4 || // Finance
                        $currentUser->department_id === 3;   // Human Resources
        
        // Filter departments based on user role
        if (!$hasFullAccess && $currentUser->role === 'HOD' && $currentUser->department_id) {
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

        // Define role hierarchy for sorting
        $roleHierarchy = [
            'Admin System' => 1,
            'MD' => 2,
            'GM' => 3,
            'OM' => 4,
            'HOD' => 5,
            'AM' => 6,
            'Staff' => 7
        ];

        // Sort users by role hierarchy
        $users = $users->sortBy(function ($user) use ($roleHierarchy) {
            return $roleHierarchy[$user->role] ?? 999; // Default to end if role not found
        })->values(); // Reset array keys

        return view('user', compact('users', 'departments'));
    }

    public function store (Request $request) {
        $currentUser = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'position' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'password' => 'required|string|min:8',
        ]);

        // Check if current user is HOD and restrict to their department
        $hasFullAccess = $currentUser->role === 'Admin System' || 
                        $currentUser->department_id === 4 || // Finance
                        $currentUser->department_id === 3;   // Human Resources
        
        if (!$hasFullAccess && $currentUser->role === 'HOD' && $currentUser->department_id) {
            if ($validated['department_id'] != $currentUser->department_id) {
                abort(403, 'You can only create users in your own department.');
            }
        }

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
        $currentUser = auth()->user();
        
        // Filter departments based on user role
        $hasFullAccess = $currentUser->role === 'Admin System' || 
                        $currentUser->department_id === 4 || // Finance
                        $currentUser->department_id === 3;   // Human Resources
        
        if (!$hasFullAccess && $currentUser->role === 'HOD' && $currentUser->department_id) {
            $departments = Department::where('id', $currentUser->department_id)->get();
        } else {
            $departments = Department::all();
        }
        
        return view('userForm', compact('departments'));
    }

    public function edit ($id) {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();
        
        // Check if current user has permission to edit this user
        $hasFullAccess = $currentUser->role === 'Admin System' || 
                        $currentUser->department_id === 4 || // Finance
                        $currentUser->department_id === 3;   // Human Resources
        
        if (!$hasFullAccess && 
            !($currentUser->role === 'HOD' && $currentUser->department_id === $user->department_id)) {
            abort(403, 'Unauthorized action.');
        }
        
        $departments = Department::all();

        return view ('editUser', compact('user', 'departments'));
    }

    public function update (Request $request, $id) {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();
        
        // Check if current user has permission to update this user
        $hasFullAccess = $currentUser->role === 'Admin System' || 
                        $currentUser->department_id === 4 || // Finance
                        $currentUser->department_id === 3;   // Human Resources
        
        if (!$hasFullAccess && 
            !($currentUser->role === 'HOD' && $currentUser->department_id === $user->department_id)) {
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

        // Check if current user is HOD and restrict to their department
        $hasFullAccess = $currentUser->role === 'Admin System' || 
                        $currentUser->department_id === 4 || // Finance
                        $currentUser->department_id === 3;   // Human Resources
        
        if (!$hasFullAccess && $currentUser->role === 'HOD' && $currentUser->department_id) {
            if ($validated['department_id'] != $currentUser->department_id) {
                abort(403, 'You can only update users in your own department.');
            }
        }

        $user->update($validated);

        return redirect()->route('user')->with('success', 'User data updated successfully!');
    }

    public function destroy ($id) {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();
        
        // Only Admin System, Finance, and Human Resources can delete users
        $hasFullAccess = $currentUser->role === 'Admin System' || 
                        $currentUser->department_id === 4 || // Finance
                        $currentUser->department_id === 3;   // Human Resources
        
        if (!$hasFullAccess) {
            abort(403, 'Unauthorized action.');
        }
        
        $user->delete();

        return redirect()->route('user')->with('success', 'User deleted successfully!');
    }

    public function impersonate(User $user)
    {
        $currentUser = auth()->user();
        
        // Only Admin System can impersonate users
        if ($currentUser->role !== 'Admin System') {
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
