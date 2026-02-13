<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
            Role::firstOrCreate(
                ['name' => $name],
                ['guard_name' => config('auth.defaults.guard', 'web')]
            );
        }
    }
}
