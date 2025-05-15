<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Department;

class InventoryController extends Controller
{
    public function index () {
        $departments = Department::all();

        return view('itemForm', compact('departments'));
    }

    public function store (Request $request) {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'year' => 'required|integer',
            'amount' => 'required|numeric',
            'department_id' => 'required|exists:departments,id',
        ]);

        Inventory::create($validated);

        return redirect()->back()->with('success', 'Item has been saved!!');
    }
}
