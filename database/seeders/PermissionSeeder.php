<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'Dashboard',
            'Manage Customer Asset',
            'Manage Work Order',
            'Manage Inventory',
            'Manage Procedure',
            'Manage Resources',
            'Tools & Equipment',
            'Roles & Permissions',
            'Manage Client',
        ];

        foreach ($modules as $module) {
            Permission::updateOrCreate(
                ['module' => $module], // avoid duplicate
                ['module' => $module]
            );
        }
    }
}