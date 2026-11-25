<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        // Crear roles
        $roles = [
            'administrador',
            'recepcionista',
            'medico',
            'paciente',
        ];

        foreach ($roles as $nombre) {
            Role::firstOrCreate([
                'name' => $nombre,
                'guard_name' => 'web',
            ]);
        }

        // Crear permisos
        $permisos = [
            'usuarios.gestionar',
            'pacientes.ver',
            'pacientes.crear',
            'medicos.gestionar',
            'horarios.gestionar',
            'citas.ver',
            'citas.crear',
            'citas.reprogramar',
            'citas.cancelar',
            'citas.atender',
            'reportes.ver',
        ];

        foreach ($permisos as $nombre) {
            Permission::firstOrCreate([
                'name' => $nombre,
                'guard_name' => 'web',
            ]);
        }

        // Permisos por rol
        $asignaciones = [
            'administrador' => $permisos,

            'recepcionista' => [
                'pacientes.ver',
                'pacientes.crear',
                'citas.ver',
                'citas.crear',
                'citas.reprogramar',
                'citas.cancelar',
            ],

            'medico' => [
                'citas.ver',
                'citas.atender',
            ],

            'paciente' => [
                'citas.ver',
                'citas.crear',
                'citas.reprogramar',
                'citas.cancelar',
            ],
        ];

        foreach ($asignaciones as $rol => $permisosRol) {
            Role::findByName($rol, 'web')
                ->syncPermissions($permisosRol);
        }

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();
    }
}
