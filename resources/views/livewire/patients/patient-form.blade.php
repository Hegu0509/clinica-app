<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        {{ $patientId ? 'Editar paciente' : 'Nuevo paciente' }}
    </h1>

    <form wire:submit="save" class="space-y-4">

        <div>
            <label for="first_name">Nombres *</label>
            <input id="first_name"
                   type="text"
                   wire:model="first_name"
                   class="w-full border rounded p-2">
            @error('first_name')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="last_name">Apellidos *</label>
            <input id="last_name"
                   type="text"
                   wire:model="last_name"
                   class="w-full border rounded p-2">
            @error('last_name')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="document_type">Tipo de documento</label>
            <select id="document_type"
                    wire:model="document_type"
                    class="w-full border rounded p-2">
                <option value="">Seleccione...</option>
                <option value="cedula">Cédula</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div>
            <label for="document_number">Número de documento</label>
            <input id="document_number"
                   type="text"
                   wire:model="document_number"
                   class="w-full border rounded p-2">
            @error('document_number')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="birth_date">Fecha de nacimiento</label>
            <input id="birth_date"
                   type="date"
                   wire:model="birth_date"
                   class="w-full border rounded p-2">
            @error('birth_date')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="phone">Teléfono</label>
            <input id="phone"
                   type="text"
                   wire:model="phone"
                   class="w-full border rounded p-2">
            @error('phone')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="address">Dirección</label>
            <textarea id="address"
                      wire:model="address"
                      class="w-full border rounded p-2">
            </textarea>
            @error('address')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="bg-blue-600 text-white px-5 py-2 rounded">
                Guardar paciente
            </button>

            <a href="{{ route('patients.index') }}"
               class="border px-5 py-2 rounded">
                Cancelar
            </a>
        </div>

    </form>

</div>

