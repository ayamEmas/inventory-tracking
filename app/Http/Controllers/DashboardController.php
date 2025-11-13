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
        $inventories = Inventory::with('department')->where('check', 1)->get();
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
                        $totalAmount = $items->sum('amount');
                        return [
                            'name' => $items->first()->asset_cat,
                            'count' => $items->count(),
                            'percentage' => $percentage,
                            'total_amount' => $totalAmount
                        ];
                    })->values();

                return [
                    'name' => $department->name,
                    'count' => $department->inventories_count,
                    'percentage' => $percentage,
                    'categories' => $categories
                ];
            });

        // Calculate asset category distribution across all inventories
        $categoryNames = [
            'B' => 'Building',
            'MV' => 'Motor Vehicle',
            'M' => 'Machinery',
            'FF' => 'Furniture & Fitting',
            'SE' => 'Site Equipment',
            'OE' => 'Office Equipment',
            'C' => 'Computer',
        ];

        $categoryDistributionRaw = $inventories
            ->groupBy('asset_cat')
            ->map(function ($group) use ($inventories, $categoryNames) {
                $totalInventories = $inventories->count();
                $count = $group->count();
                $percentage = $totalInventories > 0 ? round(($count / $totalInventories) * 100) : 0;
                $totalAmount = $group->sum('amount');

                return [
                    'code' => $group->first()->asset_cat,
                    'name' => $categoryNames[$group->first()->asset_cat] ?? $group->first()->asset_cat,
                    'count' => $count,
                    'percentage' => $percentage,
                    'total_amount' => $totalAmount,
                ];
            })
            ->sortByDesc('count')
            ->values();

        $categoryDistribution = collect($categoryNames)
            ->map(function ($name, $code) use ($categoryDistributionRaw) {
                $existing = $categoryDistributionRaw->firstWhere('code', $code);

                if ($existing) {
                    return $existing;
                }

                return [
                    'code' => $code,
                    'name' => $name,
                    'count' => 0,
                    'percentage' => 0,
                    'total_amount' => 0,
                ];
            })
            ->values();

        return view('dashboard', compact(
            'users',
            'inventories',
            'departmentDistribution',
            'deletedItems',
            'categoryDistribution'
        ));
    }
} 