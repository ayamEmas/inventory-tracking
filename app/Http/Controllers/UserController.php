<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\User;

class UserController extends Controller
{
    public function index () {
        $users = User::with('department')->get();

        return view('user', compact('users'));
    }

    public function store (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
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
        $departments = Department::all();

        return view ('editUser', compact('user', 'departments'));
    }

    public function update (Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'password' => 'required|string|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('user')->with('success', 'User data updated successfully!');
    }
}
