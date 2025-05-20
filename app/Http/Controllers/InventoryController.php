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

        if ($request->filled('year_filter')) {
            $query->whereYear('date', $request->year_filter);
        }

        $inventories = $query->get();

        return view('inventory', compact('departments', 'inventories'));
    }

    public function store (Request $request) {
        $validated = $request->validate([
            'date' => 'required|date',
            'purchase_order_no' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'supplier_email' => 'required|string|max:255',
            'supplier_address' => 'required|string|max:255',
            'supplier_contactno' => 'required|string|max:255',
            'supplier_faxno' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'asset_location' => 'required|string|max:255',
            'asset_to' => 'required|string|max:255',
            'asset_code' => 'required|string|max:255',
            'asset_cat' => 'required|string|max:255',
            'asset_type' => 'required|string|max:255',
            'item_location' => 'required|string|max:255',
            'serial_num' => 'required|string|max:255',
            'microsoft_office' => 'required|string|max:255',
            'tel_number' => 'required|string|max:255',
            'nos' => 'required|string|max:255',
            'description' => 'required|string|max:255', 
            'amount' => 'required|numeric',
            'item' => 'required|string|max:255',
        ]);

        Inventory::create($validated);

        return redirect()->back()->with('success', 'Item has been saved!!');
    }

    public function create () {
        $departments = Department::all();
        $inventories = Inventory::with('department')->get();
        
        return view ('itemForm', compact('departments', 'inventories'));
    }

    public function edit ($id) {
        $inventory = Inventory::findOrFail($id);
        $departments = Department::all();

        return view ('editInventory', compact('inventory', 'departments'));
    }

    public function update (Request $request, $id) {
        $validated = $request->validate([
            'date' => 'required|date',
            'purchase_order_no' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'supplier_email' => 'required|string|max:255',
            'supplier_address' => 'required|string|max:255',
            'supplier_contactno' => 'required|string|max:255',
            'supplier_faxno' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'asset_location' => 'required|string|max:255',
            'asset_to' => 'required|string|max:255',
            'asset_code' => 'required|string|max:255',
            'asset_cat' => 'required|string|max:255',
            'asset_type' => 'required|string|max:255',
            'item_location' => 'required|string|max:255',
            'serial_num' => 'required|string|max:255',
            'microsoft_office' => 'required|string|max:255',
            'tel_number' => 'required|string|max:255',
            'nos' => 'required|string|max:255',
            'description' => 'required|string|max:255', 
            'amount' => 'required|numeric',
            'item' => 'required|string|max:255',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($validated);

        return redirect()->route('inventory')->with('success', 'Inventory updated successfully!');
    }
}
