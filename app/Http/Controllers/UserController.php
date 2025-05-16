<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class UserController extends Controller
{
    public function index () {
        $users = User::with('department')->get();

        return view('user', compact('users'));
    }
}
