<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inventory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('department')->get();
        $inventories = Inventory::with('department')->get();
        return view('dashboard', compact('users', 'inventories'));
    }
} 