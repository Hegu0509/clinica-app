<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('pacientes.ver')
            && $user->hasAnyRole([
                'administrador',
                'recepcionista',
            ]);
    }

    public function view(User $user, Patient $patient): bool
    {
        // Personal autorizado
        if (
            $user->can('pacientes.ver')
            && $user->hasAnyRole([
                'administrador',
                'recepcionista',
            ])
        ) {
            return true;
        }

        // Paciente consultando su propio perfil
        return $user->hasRole('paciente')
            && $patient->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('pacientes.crear')
            && $user->hasAnyRole([
                'administrador',
                'recepcionista',
            ]);
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->can('pacientes.editar')
            && $user->hasAnyRole([
                'administrador',
                'recepcionista',
            ]);
    }

    public function delete(User $user, Patient $patient): bool
    {
        return false;
    }
}

