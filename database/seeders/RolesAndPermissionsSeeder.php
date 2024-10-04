<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos si no existen
        $permissions = [
            'manage pets',
            'view medical history',
            'manage appointments',
            'view and update medical records',
            'manage surgeries',
            'manage inventory',
            'manage cages',
            'process payments',
            'manage invoices',
            'view reports',
            'manage users',
            'manage prescriptions',
            'manage tickets',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Crear roles y asignar permisos
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $adminRole->givePermissionTo([
            'manage pets',
            'view medical history',
            'manage appointments',
            'view and update medical records',
            'manage surgeries',
            'manage inventory',
            'manage cages',
            'process payments',
            'manage invoices',
            'view reports',
            'manage users',
            'manage prescriptions',
            'manage tickets'
        ]);

        $vetRole = Role::firstOrCreate(['name' => 'Veterinario']);
        $vetRole->givePermissionTo([
            'manage pets',
            'view medical history',
            'manage appointments',
            'view and update medical records',
            'manage surgeries',
            'manage inventory',
            'manage cages',
            'view reports',
            'manage prescriptions'
        ]);

        $employeeRole = Role::firstOrCreate(['name' => 'Empleado']);
        $employeeRole->givePermissionTo([
            'manage pets',
            'manage appointments',
            'process payments',
            'manage invoices',
            'manage cages',
            'manage tickets',
            'manage inventory',
            'manage prescriptions'
        ]);

        $clientRole = Role::firstOrCreate(['name' => 'Cliente']);
        $clientRole->givePermissionTo([
            'manage pets',
            'view medical history',
            'manage appointments',
            'view reports',
            'manage tickets',
            'manage invoices',
            'manage prescriptions'
        ]);
    }
}
