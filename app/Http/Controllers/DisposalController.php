<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Disposal;
use App\Models\DeletedInventory;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DisposalController extends Controller
{
    public function index()
    {
        return view('pelupusan');
    }

    public function search(Request $request)
    {
        // If GET and no id_tag, just show the page
        if ($request->isMethod('get') && !$request->has('id_tag')) {
            return view('pelupusan');
        }

        $request->validate([
            'id_tag' => 'required|string|max:255'
        ]);

        // Check if the inventory is in deleted_inventories
        $deletedInventory = \App\Models\DeletedInventory::where('id_tag', $request->id_tag)->first();
        if ($deletedInventory) {
            // Also get the disposal record (by serial number or id_tag)
            $disposalData = \App\Models\Disposal::where('registrationSerialNum', $deletedInventory->serial_num)
                ->orWhere('registrationSerialNum', $deletedInventory->id_tag)
                ->latest()->first();
            return view('pelupusan', [
                'deletedInventory' => $deletedInventory,
                'isDisposed' => true,
                'disposalData' => $disposalData,
            ]);
        }

        $inventory = \App\Models\Inventory::where('id_tag', $request->id_tag)->first();
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
        ]);

        $disposalData = $request->only([
            'registrationSerialNum',
            'assetDescrip',
            'acquisitionDate',
            'assetAge',
            'oriCost',
            'currentValue',
            'stateAsset',
            'disposalMethod',
            'justification',
            'notes',
        ]);

        // Get user with ID 1 for automatic assignment
        $supervisorUser = User::find(1);
        if (!$supervisorUser) {
            return back()->withErrors(['error' => 'Supervisor user not found. Please contact administrator.']);
        }

        // Add automatic supervisor assignment
        $disposalData['supervisor1'] = $supervisorUser->id;
        $disposalData['name1'] = $supervisorUser->name;
        $disposalData['remarks1'] = null;

        Log::info('DisposalController@store: Start', ['data' => $disposalData]);

        $inventory = Inventory::where('serial_num', $request->registrationSerialNum)->first();
        if (!$inventory) {
            Log::warning('DisposalController@store: Inventory not found', ['serial_num' => $request->registrationSerialNum]);
            return back()->withErrors(['registrationSerialNum' => 'No inventory found with this serial number.']);
        }

        DB::beginTransaction();
        try {
            Log::info('DisposalController@store: Creating disposal record');
            Disposal::create($disposalData);

            Log::info('DisposalController@store: Creating deleted inventory record');
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

            Log::info('DisposalController@store: Deleting inventory record', ['id' => $inventory->id]);
            $inventory->delete();

            DB::commit();
            Log::info('DisposalController@store: Success');
            return back()->with('success', 'Disposal form submitted successfully! Inventory has been moved to deleted items.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DisposalController@store: Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'An error occurred while processing the disposal. Please try again.']);
        }
    }

    public function showApproval($id)
    {
        $disposal = Disposal::findOrFail($id);
        
        if (!empty($disposal->supervisor1) && !empty($disposal->name1) && !empty($disposal->remarks1)) {
            return redirect()->route('pelupusan')->with('error', 'This disposal has already been approved.');
        }

        $deletedInventory = DeletedInventory::where('serial_num', $disposal->registrationSerialNum)->firstOrFail();
        $hods = User::where('role', 'HOD')->get();

        return view('disposal-approval', compact('disposal', 'deletedInventory', 'hods'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'supervisor1' => 'required|exists:users,id',
            'name1' => 'required|string|max:255',
            'remarks1' => 'required|integer',
        ]);

        $disposal = Disposal::findOrFail($id);
        $disposal->update([
            'supervisor1' => $request->supervisor1,
            'name1' => $request->name1,
            'remarks1' => $request->remarks1,
        ]);

        return redirect()->route('pelupusan')->with('success', 'Disposal approved successfully!');
    }

    public function infoDisposal(Request $request)
    {
        // Get all disposals with filtering
        $disposalsQuery = Disposal::query();
        
        if ($request->filled('id_tag_filter')) {
            $disposalsQuery->where('registrationSerialNum', 'like', '%' . $request->id_tag_filter . '%');
        }
        
        if ($request->filled('disposal_method_filter')) {
            $disposalsQuery->where('disposalMethod', $request->disposal_method_filter);
        }
        
        $disposals = $disposalsQuery->latest()->get();

        // Get all deleted inventories with filtering
        $deletedInventoriesQuery = DeletedInventory::with('department');
        
        if ($request->filled('id_tag_filter')) {
            $deletedInventoriesQuery->where('id_tag', 'like', '%' . $request->id_tag_filter . '%');
        }
        
        if ($request->filled('department_filter')) {
            $deletedInventoriesQuery->where('department_id', $request->department_filter);
        }
        
        $deletedInventories = $deletedInventoriesQuery->latest()->get();

        // Get departments for filter
        $departments = Department::all();

        // Get unique disposal methods for filter
        $disposalMethods = Disposal::distinct()->pluck('disposalMethod')->filter()->values();

        return view('info-disposal', compact('disposals', 'deletedInventories', 'departments', 'disposalMethods'));
    }
}
