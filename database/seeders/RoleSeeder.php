<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super_admin' => 'Full system access - Platform Panel',
            'tenant_admin' => 'Full tenant access - Tenant Panel',
            'employee' => 'Limited tenant access - Tenant Panel',
            'customer' => 'Self-service only - Mobile App',
        ];

        foreach ($roles as $name => $description) {
            Role::firstOrCreate(['name' => $name], ['guard_name' => 'web']);
        }

        $customerPermissions = [
            'customer_view',
            'customer_view_any',
            'customer_create',
            'customer_update',
            'customer_delete',
            'customer_restore',
            'customer_restore_any',
            'customer_force_delete',
            'customer_force_delete_any',
        ];

        foreach ($customerPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission], ['guard_name' => 'web']);
        }

        $tenantAdmin = Role::where('name', 'tenant_admin')->first();
        $employee = Role::where('name', 'employee')->first();

        if ($tenantAdmin) {
            $tenantAdmin->givePermissionTo($customerPermissions);
        }

        if ($employee) {
            $employee->givePermissionTo([
                'customer_view',
                'customer_view_any',
                'customer_create',
                'customer_update',
            ]);
        }
    }
}
