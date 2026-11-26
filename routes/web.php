<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Models\Patient;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::middleware(['auth', 'verified'])->group(function () {

    // Solo administradores
    Route::get('/admin', function () {
        return 'Bienvenido al panel de administración';
    })->middleware('role:administrador')
      ->name('admin.index');

    // Solo recepcionistas
    Route::get('/recepcion', function () {
        return 'Bienvenido al panel de recepción';
    })->middleware('role:recepcionista')
      ->name('recepcion.index');

    // Solo médicos
    Route::get('/medico', function () {
        return 'Bienvenido al panel médico';
    })->middleware('role:medico')
      ->name('medico.index');

    // Solo pacientes
    Route::get('/paciente', function () {
        return 'Bienvenido al panel del paciente';
    })->middleware('role:paciente')
      ->name('paciente.index');

});

Route::middleware(['auth', 'verified'])
    ->prefix('pacientes')
    ->name('patients.')
    ->group(function () {

        Route::get('/', function () {
            Gate::authorize('viewAny', Patient::class);

            return view('patients.index');
        })->name('index');

        Route::get('/crear', function () {
            Gate::authorize('create', Patient::class);

            return view('patients.create');
        })->name('create');

        Route::get('/{patient}/editar', function (Patient $patient) {
            Gate::authorize('update', $patient);

            return view('patients.edit', compact('patient'));
        })->name('edit');

        Route::get('/{patient}', function (Patient $patient) {
            Gate::authorize('view', $patient);

            return view('patients.show', compact('patient'));
        })->name('show');

    });
