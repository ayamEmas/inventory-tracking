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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DeletedInventory;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
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
        $assetCatCode = $request->asset_cat;

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
        $idTag = "QHSB/HQ/{$departmentCode}/{$assetCatCode}/{$year}/{$sequenceStr}";

        // Add id_tag to validated data
        $validated['id_tag'] = $idTag;

        // Handle image upload with id_tag and date as filename
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $dateFormatted = date('Y-m-d', strtotime($request->date));
            $imageName = $idTag . '_' . $dateFormatted . '.' . $extension;
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ]);

        $inventory = Inventory::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($inventory->image && Storage::disk('public')->exists('images/' . $inventory->image)) {
                Storage::disk('public')->delete('images/' . $inventory->image);
            }

            // Upload new image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $dateFormatted = date('Y-m-d', strtotime($request->date));
            $imageName = $inventory->id_tag . '_' . $dateFormatted . '.' . $extension;
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        }

        $inventory->update($validated);

        return redirect()->route('inventory')->with('success', 'Inventory updated successfully!');
    }

    public function downloadQr($id)
    {
        $inventory = Inventory::findOrFail($id);
        $url = url(route('inventories.download-single-pdf', $inventory->id, false));

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

        // Replace slashes with hyphens in the filename
        $filename = str_replace(['/', '\\'], '-', $inventory->id_tag);
        
        return response($result->getString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qr-' . $filename . '.png"');
    }

    public function downloadPdf(Request $request)
    {
        $type = $request->type;
        $value = $request->value;

        $query = Inventory::with('department');

        switch ($type) {
            case 'department':
                $query->whereHas('department', function($q) use ($value) {
                    $q->where('name', $value);
                });
                $title = "Inventory - {$value} Department";
                break;
            case 'year':
                $query->whereYear('date', $value);
                $title = "Inventory - Year {$value}";
                break;
            default:
                $title = "Complete Inventory List";
                break;
        }

        $inventories = $query->get();

        // Generate QR codes for all items
        $inventoriesWithQr = $inventories->map(function ($inventory) {
            // Generate PDF data
            $pdf = PDF::loadView('pdf.single-inventory', [
                'inventory' => $inventory,
                'date' => now()->format('F d, Y'),
                'qrCode' => '' // We don't need QR code in the PDF since this is the QR code itself
            ]);
            
            // Get PDF content as base64
            $pdfContent = base64_encode($pdf->output());
            
            // Create QR code with PDF data
            $qrCode = QrCode::create($pdfContent)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
                ->setSize(100)
                ->setMargin(5)
                ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));

            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            $inventory->qrCode = base64_encode($result->getString());
            return $inventory;
        });

        // Group by department
        $groupedInventories = $inventoriesWithQr->groupBy('department.name');
        
        // Separate "None" department items
        $noDepartmentItems = $groupedInventories->pull('None');
        
        // Sort remaining departments alphabetically
        $groupedInventories = $groupedInventories->sortKeys();
        
        // Add "None" back at the end if it exists
        if ($noDepartmentItems) {
            $groupedInventories->put('None', $noDepartmentItems);
        }

        $pdf = PDF::loadView('pdf.inventory', [
            'title' => $title,
            'groupedInventories' => $groupedInventories,
            'date' => now()->format('F d, Y')
        ]);

        // Replace slashes with hyphens in the filename
        $filename = str_replace(['/', '\\'], '-', strtolower(str_replace(' ', '-', $title)));
        return $pdf->download('inventory-' . $filename . '.pdf');
    }

    public function downloadSinglePdf($id)
    {
        $inventory = Inventory::with('department')->findOrFail($id);
        $url = route('inventories.download-single-pdf', $inventory->id);

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
        $qrCodeString = $result->getString();

        $pdf = PDF::loadView('pdf.single-inventory', [
            'inventory' => $inventory,
            'date' => now()->format('F d, Y'),
            'qrCode' => $qrCodeString
        ]);

        // Replace slashes with hyphens in the filename
        $filename = str_replace(['/', '\\'], '-', $inventory->id_tag);
        return $pdf->download('inventory-' . $filename . '.pdf');
    }

    public function downloadDeletedPdf($id)
    {
        $inventory = DeletedInventory::with('department')->findOrFail($id);
        $url = route('inventories.download-deleted-pdf', $inventory->id);

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
        $qrCodeString = $result->getString();

        $pdf = PDF::loadView('pdf.single-inventory', [
            'inventory' => $inventory,
            'date' => now()->format('F d, Y'),
            'qrCode' => $qrCodeString,
            'isDeleted' => true
        ]);

        // Replace slashes with hyphens in the filename
        $filename = str_replace(['/', '\\'], '-', $inventory->id_tag);
        return $pdf->download('deleted-inventory-' . $filename . '.pdf');
    }

    public function deletedItems(Request $request)
    {
        $query = DeletedInventory::with('department');

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

        $deletedItems = $query->orderBy('deleted_at', 'desc')->get();
        $departments = Department::all();

        return view('deleted-inventory', compact('deletedItems', 'departments'));
    }

    public function restore($id)
    {
        $deletedItem = DeletedInventory::findOrFail($id);
        
        // Create a new record in inventories
        Inventory::create([
            'date' => $deletedItem->date,
            'purchase_order_no' => $deletedItem->purchase_order_no,
            'supplier_name' => $deletedItem->supplier_name,
            'supplier_email' => $deletedItem->supplier_email,
            'supplier_address' => $deletedItem->supplier_address,
            'supplier_contactno' => $deletedItem->supplier_contactno,
            'supplier_faxno' => $deletedItem->supplier_faxno,
            'department_id' => $deletedItem->department_id,
            'asset_location' => $deletedItem->asset_location,
            'asset_to' => $deletedItem->asset_to,
            'asset_code' => $deletedItem->asset_code,
            'asset_cat' => $deletedItem->asset_cat,
            'asset_type' => $deletedItem->asset_type,
            'item_location' => $deletedItem->item_location,
            'serial_num' => $deletedItem->serial_num,
            'microsoft_office' => $deletedItem->microsoft_office,
            'tel_number' => $deletedItem->tel_number,
            'nos' => $deletedItem->nos,
            'description' => $deletedItem->description,
            'amount' => $deletedItem->amount,
            'item' => $deletedItem->item,
            'id_tag' => $deletedItem->id_tag,
        ]);

        // Delete from deleted_inventories
        $deletedItem->delete();

        return redirect()->route('inventories.deleted')->with('success', 'Item has been restored successfully!');
    }
}
