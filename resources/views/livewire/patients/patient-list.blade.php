<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">
            Gestión de pacientes
        </h1>

        @can('create', \App\Models\Patient::class)
            <a href="{{ route('patients.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Nuevo paciente
            </a>
        @endcan
    </div>

    <div class="mb-4">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Buscar por nombre o documento"
            class="w-full border rounded p-2"
        >
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-100 text-gray-900">
                    <th class="border p-3">Nombres</th>
                    <th class="border p-3">Apellidos</th>
                    <th class="border p-3">Documento</th>
                    <th class="border p-3">Teléfono</th>
                    <th class="border p-3">Estado</th>
                    <th class="border p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($patients as $patient)
                    <tr wire:key="patient-{{ $patient->id }}">
                        <td class="border p-3">
                            {{ $patient->first_name }}
                        </td>

                        <td class="border p-3">
                            {{ $patient->last_name }}
                        </td>

                        <td class="border p-3">
                            {{ $patient->document_number ?? 'N/D' }}
                        </td>

                        <td class="border p-3">
                            {{ $patient->phone ?? 'N/D' }}
                        </td>

                        <td class="border p-3">
                            {{ $patient->is_active ? 'Activo' : 'Inactivo' }}
                        </td>

                        <td class="border p-3">
                            <a href="{{ route('patients.show', $patient) }}"
                               class="text-blue-600">
                                Ver
                            </a>

                            @can('update', $patient)
                                <a href="{{ route('patients.edit', $patient) }}"
                                   class="ml-3 text-green-600">
                                    Editar
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center">
                            No se encontraron pacientes.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $patients->links() }}
    </div>

</div>

