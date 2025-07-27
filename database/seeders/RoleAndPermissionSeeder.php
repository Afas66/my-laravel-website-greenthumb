<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Plant management
            'view_plants',
            'create_plants',
            'edit_plants',
            'delete_plants',
            
            // Category management
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            
            // Order management
            'view_orders',
            'edit_orders',
            'delete_orders',
            'update_order_status',
            
            // User management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Inventory management
            'view_inventory',
            'edit_inventory',
            'bulk_update_inventory',
            
            // Reports
            'view_reports',
            'export_reports',
            'view_analytics',
            
            // Customer inquiries
            'view_inquiries',
            'respond_to_inquiries',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Customer role - basic permissions
        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'view_plants',
            'view_categories',
        ]);

        // Staff role - order and inventory management
        $staffRole = Role::create(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view_plants',
            'view_categories',
            'view_orders',
            'edit_orders',
            'update_order_status',
            'view_inventory',
            'edit_inventory',
            'bulk_update_inventory',
            'view_inquiries',
            'respond_to_inquiries',
        ]);

        // Admin role - all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create default admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@greenthumb.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create default staff user
        $staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@greenthumb.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $staff->assignRole('staff');

        // Create default customer user
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@greenthumb.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');
    }
}
