<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Department;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Label\Label;

class InventoryController extends Controller
{
    public function index (Request $request) {
        $departments = Department::all();

        $query = Inventory::with('department');

        if ($request->filled('item_filter')) {
            $query->where('item', 'like', '%' . $request->item_filter . '%');
        }

        if ($request->filled('id_tag_filter')) {
            $query->where('id_tag', 'like', '%' . $request->id_tag_filter . '%');
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

        // Get department code based on department name
        $department = Department::find($request->department_id);
        $departmentCode = match(strtolower($department->name)) {
            'information technology' => 'IT',
            'contract' => 'CON',
            'finance' => 'FIN',
            'human resources' => 'HR',
            'operation' => 'OPE',
            default => 'NONE'
        };

        // Get year from date
        $year = date('y', strtotime($request->date));

        // Get first 3 letters of asset_cat
        $assetCatCode = strtoupper(substr($request->asset_cat, 0, 3));

        // Get the last sequence number for this combination
        $lastInventory = Inventory::where('asset_location', $request->asset_location)
            ->where('department_id', $request->department_id)
            ->where('asset_cat', $request->asset_cat)
            ->whereYear('date', date('Y', strtotime($request->date)))
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastInventory ? intval(substr($lastInventory->id_tag, -3)) + 1 : 1;
        $sequenceStr = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        // Generate id_tag
        $idTag = "QHSB/{$request->asset_location}/{$departmentCode}/{$year}/{$assetCatCode}/{$sequenceStr}";

        // Add id_tag to validated data
        $validated['id_tag'] = $idTag;

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

    public function destroy ($id) {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory')->with('success', 'Inventory deleted successfully!');
    }

    public function downloadQr($id)
    {
        $inventory = Inventory::findOrFail($id);
        $url = route('inventories.edit', $inventory->id);

        $qrCode = QrCode::create($url)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filename = 'qr-' . $inventory->id_tag . '.png';
        
        return response($result->getString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
