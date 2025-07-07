<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Disposal;
use App\Models\DeletedInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisposalController extends Controller
{
    public function index()
    {
        return view('pelupusan');
    }

    public function search(Request $request)
    {
        $request->validate([
            'id_tag' => 'required|string|max:255'
        ]);

        $inventory = Inventory::where('id_tag', $request->id_tag)->first();

        if (!$inventory) {
            return back()->withErrors(['id_tag' => 'Inventory with this ID tag not found.']);
        }

        return view('pelupusan', compact('inventory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registrationSerialNum' => 'required|string|max:255',
            'assetDescrip' => 'required|string|max:255',
            'acquisitionDate' => 'required|date',
            'assetAge' => 'required|integer|min:0',
            'oriCost' => 'required|numeric|min:0',
            'currentValue' => 'required|numeric|min:0',
            'stateAsset' => 'required|string|max:255',
            'disposalMethod' => 'required|string|max:255',
            'justification' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'supervisor1' => 'required|string|max:255',
            'name1' => 'required|string|max:255',
            'remarks1' => 'required|integer|min:0|max:1',
        ]);

        try {
            DB::beginTransaction();

            // Find the inventory by serial_num matching registrationSerialNum
            $inventory = Inventory::where('serial_num', $request->registrationSerialNum)->firstOrFail();

            // Store disposal data
            Disposal::create($request->all());

            // Store in deleted_inventories table
            DeletedInventory::create([
                'date' => $inventory->date,
                'purchase_order_no' => $inventory->purchase_order_no,
                'supplier_name' => $inventory->supplier_name,
                'supplier_email' => $inventory->supplier_email,
                'supplier_address' => $inventory->supplier_address,
                'supplier_contactno' => $inventory->supplier_contactno,
                'supplier_faxno' => $inventory->supplier_faxno,
                'department_id' => $inventory->department_id,
                'asset_location' => $inventory->asset_location,
                'asset_to' => $inventory->asset_to,
                'asset_code' => $inventory->asset_code,
                'asset_cat' => $inventory->asset_cat,
                'asset_type' => $inventory->asset_type,
                'item_location' => $inventory->item_location,
                'serial_num' => $inventory->serial_num,
                'microsoft_office' => $inventory->microsoft_office,
                'tel_number' => $inventory->tel_number,
                'nos' => $inventory->nos,
                'description' => $inventory->description,
                'amount' => $inventory->amount,
                'item' => $inventory->item,
                'id_tag' => $inventory->id_tag,
                'deleted_at' => now()
            ]);

            // Delete from main inventories table
            $inventory->delete();

            DB::commit();

            return back()->with('success', 'Disposal form submitted successfully! Inventory has been moved to deleted items.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while processing the disposal. Please try again.']);
        }
    }
}
