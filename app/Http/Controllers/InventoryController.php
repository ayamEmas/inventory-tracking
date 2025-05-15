<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Department;

class InventoryController extends Controller
{
    public function index (Request $request) {
        $departments = Department::all();

        $query = Inventory::with('department');

        if ($request->filled('item_filter')) {
            $query->where('item', 'like', '%' . $request->item_filter . '%');
        }

        if ($request->filled('department_filter')) {
            $query->whereHas('department', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->department_filter . '%');
            });
        }

        $inventories = $query->get();

        return view('inventory', compact('departments', 'inventories'));
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

    public function create () {
        $departments = Department::all();
        $inventories = Inventory::with('department')->get();
        
        return view ('itemForm', compact('departments', 'inventories'));
    }
}
