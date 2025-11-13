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
use Illuminate\Support\Facades\Storage;

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
            $this->ensureDisposalIdTag($deletedInventory->id_tag, $deletedInventory->serial_num);

            // Also get the disposal record (by id_tag)
            $disposalData = \App\Models\Disposal::where('id_tag', $deletedInventory->id_tag)
                ->latest()->first();

            $remarks = $disposalData
                ? collect([$disposalData->remarks1, $disposalData->remarks2, $disposalData->remarks3])
                : collect();

            $hasRejection = $disposalData && $remarks->contains(2);
            $allApproved = $disposalData && $remarks->filter(fn ($remark) => !is_null($remark))->count() === 3
                && $remarks->every(fn ($remark) => $remark === 1);

            return view('pelupusan', [
                'record' => $deletedInventory,
                'deletedInventory' => $deletedInventory,
                'inventory' => null,
                'isDisposed' => $allApproved,
                'disposalData' => $disposalData,
                'showForm' => false,
                'showStatus' => $disposalData && !$hasRejection,
                'disposalRejected' => $hasRejection,
            ]);
        }

        $inventory = \App\Models\Inventory::where('id_tag', $request->id_tag)->first();
        if (!$inventory) {
            return back()->withErrors(['id_tag' => 'Inventory with this ID tag not found.']);
        }

        $this->ensureDisposalIdTag($inventory->id_tag, $inventory->serial_num);

        $disposalData = \App\Models\Disposal::where('id_tag', $inventory->id_tag)
            ->latest()
            ->first();

        $remarks = $disposalData
            ? collect([$disposalData->remarks1, $disposalData->remarks2, $disposalData->remarks3])
            : collect();

        $hasRejection = $disposalData && $remarks->contains(2);
        $allApproved = $disposalData && $remarks->filter(fn ($remark) => !is_null($remark))->count() === 3
            && $remarks->every(fn ($remark) => $remark === 1);

        $showForm = !$disposalData || $hasRejection;
        $showStatus = $disposalData && !$hasRejection;

        return view('pelupusan', [
            'inventory' => $inventory,
            'record' => $inventory,
            'disposalData' => $disposalData,
            'isDisposed' => $allApproved,
            'showForm' => $showForm,
            'showStatus' => $showStatus,
            'disposalRejected' => $hasRejection,
        ]);
    }

    protected function ensureDisposalIdTag(?string $idTag, ?string $registrationSerial): void
    {
        if (!$idTag || !$registrationSerial) {
            return;
        }

        Disposal::where('registrationSerialNum', $registrationSerial)
            ->where(function ($query) use ($idTag) {
                $query->whereNull('id_tag')
                    ->orWhere('id_tag', '')
                    ->orWhere('id_tag', '!=', $idTag);
            })
            ->update(['id_tag' => $idTag]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'registrationSerialNum' => 'required|string|max:255',
            'id_tag' => 'required|string|max:255',
            'assetDescrip' => 'required|string|max:255',
            'acquisitionDate' => 'required|date',
            'assetAge' => 'required|integer|min:0',
            'oriCost' => 'required|numeric|min:0',
            'currentValue' => 'required|numeric|min:0',
            'stateAsset' => 'required|string|max:255',
            'disposalMethod' => 'required|string|max:255',
            'justification' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $inventory = Inventory::where('id_tag', $request->id_tag)->first();

        if (!$inventory) {
            return back()->withErrors(['id_tag' => 'No inventory found with this ID tag.']);
        }

        $existingDisposal = Disposal::where('id_tag', $inventory->id_tag)
            ->latest()
            ->first();

        if ($existingDisposal) {
            $statuses = collect([$existingDisposal->remarks1, $existingDisposal->remarks2, $existingDisposal->remarks3]);

            if ($statuses->contains(2)) {
                // Allow a new submission if the previous one was rejected by any supervisor.
            } elseif ($statuses->contains(null)) {
                return back()->withErrors(['id_tag' => 'A disposal request for this asset is already pending approval.']);
            } else {
                return back()->withErrors(['id_tag' => 'This asset has already been fully approved for disposal.']);
            }
        }

        $disposalData = $request->only([
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

        if ($request->hasFile('picture')) {
            $disposalData['picture_path'] = $request->file('picture')->store('disposals', 'public');
        }

        // Ensure identifiers come from the inventory record
        $disposalData['registrationSerialNum'] = $inventory->serial_num;
        $disposalData['id_tag'] = $inventory->id_tag;

        // Set supervisor values manually
        $disposalData['supervisor1'] = 5; // Set supervisor ID
        $supervisor1 = User::find(5);
        $disposalData['name1'] = $supervisor1 ? $supervisor1->name : 'Unknown'; // Get name from users table
        $disposalData['remarks1'] = null; // 1 for approve, 2 for reject, null for pending
        
        $disposalData['supervisor2'] = 7; // Set supervisor ID
        $supervisor2 = User::find(7);
        $disposalData['name2'] = $supervisor2 ? $supervisor2->name : 'Unknown'; // Get name from users table
        $disposalData['remarks2'] = null; // Pending
        
        $disposalData['supervisor3'] = 8; // Set supervisor ID
        $supervisor3 = User::find(8);
        $disposalData['name3'] = $supervisor3 ? $supervisor3->name : 'Unknown'; // Get name from users table
        $disposalData['remarks3'] = null; // Pending

        Log::info('DisposalController@store: Start', ['id_tag' => $inventory->id_tag, 'disposalData' => $disposalData]);

        DB::beginTransaction();
        try {
            Log::info('DisposalController@store: Creating disposal record');
            Disposal::create($disposalData);

            DB::commit();
            Log::info('DisposalController@store: Success');
            
            // Add debugging
            session()->flash('success', 'Disposal form submitted successfully! The request is now pending supervisor approvals.');
            Log::info('DisposalController@store: Success message set', ['session_id' => session()->getId()]);
            
            return back()->with('success', 'Disposal form submitted successfully! The request is now pending supervisor approvals.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DisposalController@store: Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'An error occurred while processing the disposal. Please try again.']);
        }
    }

    public function showApproval($id)
    {
        $disposal = Disposal::findOrFail($id);
        
        // Find the deleted inventory record
        $deletedInventory = DeletedInventory::where('id_tag', $disposal->id_tag)
            ->orWhere('serial_num', $disposal->registrationSerialNum)
            ->first();

        if (!$deletedInventory) {
            $deletedInventory = Inventory::where('id_tag', $disposal->id_tag)
                ->orWhere('serial_num', $disposal->registrationSerialNum)
                ->firstOrFail();
        }

        return view('disposal-approval', compact('disposal', 'deletedInventory'));
    }

    public function approve(Request $request, $id)
    {

        $disposal = Disposal::findOrFail($id);
        $disposal->update([
            'remarks1' => $request->remarks1,
        ]);
        $disposal->refresh();
        $this->finalizeDisposal($disposal);

        return redirect()->route('info.disposal')->with('success', 'Disposal approved successfully!');
    }

    public function approve2(Request $request, $id)
    {

        $disposal = Disposal::findOrFail($id);
        $disposal->update([
            'remarks2' => $request->remarks2,
        ]);
        $disposal->refresh();
        $this->finalizeDisposal($disposal);

        return redirect()->route('info.disposal')->with('success', 'Disposal approved by General Manager successfully!');
    }

    public function approve3(Request $request, $id)
    {

        $disposal = Disposal::findOrFail($id);
        $disposal->update([
            'remarks3' => $request->remarks3,
        ]);
        $disposal->refresh();
        $this->finalizeDisposal($disposal);

        return redirect()->route('info.disposal')->with('success', 'Disposal approved by Managing Director successfully!');
    }

    public function updateDisposal(Request $request, $id)
    {
        $disposal = Disposal::findOrFail($id);

        $userId = auth()->id();

        $assignedSupervisors = [
            $disposal->supervisor1,
            $disposal->supervisor2,
            $disposal->supervisor3,
        ];

        if (!in_array($userId, array_filter($assignedSupervisors))) {
            abort(403, 'Only assigned supervisors can update this disposal.');
        }

        $remarks = [$disposal->remarks1, $disposal->remarks2, $disposal->remarks3];

        if (in_array(2, $remarks, true)) {
            return back()->withErrors(['update-error' => 'This disposal has been rejected and cannot be modified.']);
        }

        if (collect($remarks)->every(fn ($remark) => $remark === 1)) {
            return back()->withErrors(['update-error' => 'This disposal is already fully approved and cannot be modified.']);
        }

        $validated = $request->validate([
            'assetDescrip' => 'required|string|max:255',
            'acquisitionDate' => 'required|date',
            'assetAge' => 'required|integer|min:0',
            'oriCost' => 'required|numeric|min:0',
            'currentValue' => 'required|numeric|min:0',
            'stateAsset' => 'required|string|max:255',
            'disposalMethod' => 'required|string|max:255',
            'justification' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        if ($request->hasFile('picture')) {
            if ($disposal->picture_path && Storage::disk('public')->exists($disposal->picture_path)) {
                Storage::disk('public')->delete($disposal->picture_path);
            }

            $validated['picture_path'] = $request->file('picture')->store('disposals', 'public');
        }

        $disposal->update($validated);

        return redirect()
            ->route('disposal.approval', $disposal->id)
            ->with('success', 'Disposal information updated successfully.');
    }

    protected function finalizeDisposal(Disposal $disposal): void
    {
        $remarks = [$disposal->remarks1, $disposal->remarks2, $disposal->remarks3];

        if (in_array(2, $remarks, true)) {
            Log::info('DisposalController@finalizeDisposal: Disposal rejected by at least one supervisor, inventory remains.', ['disposal_id' => $disposal->id]);
            return;
        }

        if (!collect($remarks)->every(fn ($remark) => $remark === 1)) {
            // Still pending approvals.
            return;
        }

        $alreadyDeleted = DeletedInventory::where('id_tag', $disposal->id_tag)
            ->exists();

        if ($alreadyDeleted) {
            Log::info('DisposalController@finalizeDisposal: Deleted inventory already exists for this disposal.', ['disposal_id' => $disposal->id]);
            return;
        }

        $inventory = Inventory::where('id_tag', $disposal->id_tag)
            ->first();

        if (!$inventory) {
            Log::warning('DisposalController@finalizeDisposal: Inventory not found during finalization.', [
                'disposal_id' => $disposal->id,
                'id_tag' => $disposal->id_tag,
            ]);
            return;
        }

        DB::transaction(function () use ($inventory) {
            Log::info('DisposalController@finalizeDisposal: Creating deleted inventory snapshot.', ['inventory_id' => $inventory->id]);

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
                'image' => $inventory->image,
                'id_tag' => $inventory->id_tag,
                'deleted_at' => now(),
            ]);

            Log::info('DisposalController@finalizeDisposal: Removing inventory after full approval.', ['inventory_id' => $inventory->id]);
            $inventory->delete();
        });
    }

    public function infoDisposal(Request $request)
    {
        // Get all disposals with filtering
        $disposalsQuery = Disposal::with(['deletedInventory', 'inventory']);
        
        if ($request->filled('id_tag_filter')) {
            $disposalsQuery->where('id_tag', 'like', '%' . $request->id_tag_filter . '%');
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

        // Define department hierarchy for sorting
        $departmentHierarchy = [
            'Human Resources' => 1,
            'Finance' => 2,
            'Contract' => 3,
            'Operation' => 4,
            'Information Technology' => 5,
            'None' => 6
        ];

        // Get current user's department
        $currentUserDepartment = auth()->user()->department->name ?? 'None';

        // Sort deleted inventories by department hierarchy with user's department first
        $deletedInventories = $deletedInventories->sortBy(function ($item) use ($departmentHierarchy, $currentUserDepartment) {
            $deptName = $item->department->name ?? 'None';
            
            // If it's the user's own department, give it priority 0 (highest)
            if ($deptName === $currentUserDepartment) {
                return 0;
            }
            
            // Otherwise use the hierarchy order
            return $departmentHierarchy[$deptName] ?? 999;
        })->values(); // Reset array keys

        // Get departments for filter
        $departments = Department::all();

        // Get unique disposal methods for filter
        $disposalMethods = Disposal::distinct()->pluck('disposalMethod')->filter()->values();

        return view('info-disposal', compact('disposals', 'deletedInventories', 'departments', 'disposalMethods'));
    }
}
