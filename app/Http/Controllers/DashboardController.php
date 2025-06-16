<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inventory;
use App\Models\Department;
use App\Models\DeletedInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('department')->get();
        $inventories = Inventory::with('department')->get();
        $deletedItems = DeletedInventory::with('department')->get();
        
        // Calculate department distribution with categories
        $departmentDistribution = Department::withCount('inventories')
            ->get()
            ->map(function ($department) use ($inventories) {
                $departmentItems = $inventories->where('department_id', $department->id);
                $total = $inventories->count();
                $percentage = $total > 0 ? round(($department->inventories_count / $total) * 100) : 0;

                // Calculate category distribution within department
                $categories = $departmentItems->groupBy('asset_cat')
                    ->map(function ($items) use ($departmentItems) {
                        $deptTotal = $departmentItems->count();
                        $percentage = $deptTotal > 0 ? round(($items->count() / $deptTotal) * 100) : 0;
                        return [
                            'name' => $items->first()->asset_cat,
                            'count' => $items->count(),
                            'percentage' => $percentage
                        ];
                    })->values();

                return [
                    'name' => $department->name,
                    'count' => $department->inventories_count,
                    'percentage' => $percentage,
                    'categories' => $categories
                ];
            });

        return view('dashboard', compact('users', 'inventories', 'departmentDistribution', 'deletedItems'));
    }
} 