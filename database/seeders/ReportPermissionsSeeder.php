<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ReportPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $reports = [
            'revenue' => 'Revenue Report',
            'bookings' => 'Bookings Report',
            'customers' => 'Customer Report',
            'employees' => 'Employee Performance Report',
            'inventory' => 'Inventory Report',
            'services' => 'Services Report',
            'promotions' => 'Promotions Report',
            'payments' => 'Payments Report',
            'appointments' => 'Appointments Report',
            'daily_sales' => 'Daily Sales Report',
            'weekly_sales' => 'Weekly Sales Report',
            'monthly_sales' => 'Monthly Sales Report',
            'staff_commission' => 'Staff Commission Report',
            'product_sales' => 'Product Sales Report',
            'customer_retention' => 'Customer Retention Report',
            'peak_hours' => 'Peak Hours Report',
            'cancellation' => 'Cancellation Report',
            'no_show' => 'No-Show Report',
            'deposit' => 'Deposit Report',
            'tax' => 'Tax Report',
        ];

        foreach ($reports as $key => $label) {
            Permission::firstOrCreate(
                ['name' => "view_report_{$key}", 'guard_name' => 'web']
            );
        }

        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $reportPermissions = Permission::where('name', 'like', 'view_report_%')->pluck('name')->toArray();
            $superAdmin->givePermissionTo($reportPermissions);
        }

        $tenantAdmin = Role::where('name', 'tenant_admin')->first();
        if ($tenantAdmin) {
            $tenantAdmin->givePermissionTo([
                'view_report_revenue',
                'view_report_bookings',
                'view_report_customers',
                'view_report_employees',
                'view_report_appointments',
                'view_report_daily_sales',
                'view_report_weekly_sales',
                'view_report_monthly_sales',
            ]);
        }
    }
}
