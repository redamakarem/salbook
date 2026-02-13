<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        $resources = ['tenant', 'user', 'customer', 'role'];

        $prefixes = [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'restore',
            'restore_any',
            'force_delete',
            'force_delete_any',
            'replicate',
            'reorder',
        ];

        foreach ($resources as $resource) {
            foreach ($prefixes as $prefix) {
                Permission::firstOrCreate(
                    ['name' => "{$prefix}_{$resource}", 'guard_name' => 'web']
                );
            }
        }

        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $allPermissions = Permission::where('guard_name', 'web')->pluck('name')->toArray();
            $superAdmin->syncPermissions($allPermissions);
        }

        $tenantAdmin = Role::where('name', 'tenant_admin')->first();
        if ($tenantAdmin) {
            $tenantAdminPermissions = [
                'view_user', 'view_any_user', 'create_user', 'update_user', 'delete_user',
                'view_customer', 'view_any_customer', 'create_customer', 'update_customer', 'delete_customer',
                'view_role', 'view_any_role',
            ];
            $tenantAdmin->syncPermissions($tenantAdminPermissions);
        }

        $employee = Role::where('name', 'employee')->first();
        if ($employee) {
            $employeePermissions = [
                'view_customer', 'view_any_customer', 'create_customer', 'update_customer',
            ];
            $employee->syncPermissions($employeePermissions);
        }
    }
}
