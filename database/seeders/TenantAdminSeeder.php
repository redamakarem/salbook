<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantAdminSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'demo-salon'],
            [
                'name' => 'Demo Salon',
                'domain' => 'demo.salonflow.test',
                'is_active' => true,
            ]
        );

        $tenantAdmin = User::firstOrCreate(
            ['email' => 'admin@demo-salon.com'],
            [
                'name' => 'Demo Salon Admin',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'email_verified_at' => now(),
            ]
        );
        $tenantAdmin->assignRole('tenant_admin');

        $employee = User::firstOrCreate(
            ['email' => 'employee@demo-salon.com'],
            [
                'name' => 'Demo Employee',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'email_verified_at' => now(),
            ]
        );
        $employee->assignRole('employee');
    }
}
