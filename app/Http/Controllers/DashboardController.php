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
        
        // Calculate department distribution
        $departmentDistribution = Department::withCount('inventories')
            ->get()
            ->map(function ($department) use ($inventories) {
                $total = $inventories->count();
                $percentage = $total > 0 ? round(($department->inventories_count / $total) * 100) : 0;
                return [
                    'name' => $department->name,
                    'count' => $department->inventories_count,
                    'percentage' => $percentage
                ];
            });

        return view('dashboard', compact('users', 'inventories', 'departmentDistribution', 'deletedItems'));
    }
} 