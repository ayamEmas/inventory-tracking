<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['Human Resources', 'Finance', 'Contract', 'Information Technology', 'Operation'];

        foreach ($departments as $name) {
            Department::create(['name' => $name]);
        }
    }
}
