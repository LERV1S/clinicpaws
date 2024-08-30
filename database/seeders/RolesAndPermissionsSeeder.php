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
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        Permission::create(['name' => 'manage pets']);
        Permission::create(['name' => 'view medical history']);
        Permission::create(['name' => 'manage appointments']);
        Permission::create(['name' => 'view and update medical records']);
        Permission::create(['name' => 'manage surgeries']);
        Permission::create(['name' => 'manage inventory']);
        Permission::create(['name' => 'manage cages']);
        Permission::create(['name' => 'process payments']);
        Permission::create(['name' => 'manage invoices']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'manage users']);

        // Crear roles y asignar permisos
        $adminRole = Role::create(['name' => 'Administrador']);
        $adminRole->givePermissionTo(Permission::all());

        $vetRole = Role::create(['name' => 'Veterinario']);
        $vetRole->givePermissionTo([
            'manage pets',
            'view medical history',
            'manage appointments',
            'view and update medical records',
            'manage surgeries',
            'manage inventory',
            'manage cages',
            'view reports'
        ]);

        $employeeRole = Role::create(['name' => 'Empleado']);
        $employeeRole->givePermissionTo([
            'manage pets',
            'manage appointments',
            'process payments',
            'manage invoices',
            'manage cages'
        ]);

        $clientRole = Role::create(['name' => 'Cliente']);
        $clientRole->givePermissionTo([
            'manage pets',
            'view medical history',
            'manage appointments',
            'view reports'
        ]);
    }
}
