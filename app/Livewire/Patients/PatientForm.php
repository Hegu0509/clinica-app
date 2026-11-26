<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;

class PatientForm extends Component
{
    #[Locked]
    public ?int $patientId = null;

    public string $first_name = '';
    public string $last_name = '';
    public string $document_type = '';
    public string $document_number = '';
    public string $birth_date = '';
    public string $phone = '';
    public string $address = '';

    public function mount(?Patient $patient = null): void
    {
        if ($patient && $patient->exists) {

            Gate::authorize('update', $patient);

            $this->patientId = $patient->id;
            $this->first_name = $patient->first_name;
            $this->last_name = $patient->last_name;
            $this->document_type =
                $patient->document_type ?? '';
            $this->document_number =
                $patient->document_number ?? '';
            $this->birth_date =
                $patient->birth_date?->format('Y-m-d') ?? '';
            $this->phone = $patient->phone ?? '';
            $this->address = $patient->address ?? '';

        } else {
            Gate::authorize('create', Patient::class);
        }
    }

    public function save()
    {
        $patient = $this->patientId
            ? Patient::findOrFail($this->patientId)
            : null;

        if ($patient) {
            Gate::authorize('update', $patient);
        } else {
            Gate::authorize('create', Patient::class);
        }

        $data = $this->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'document_type' => 'nullable|string|max:20',
            'document_number' => 'nullable|string|max:30',
            'birth_date' => 'nullable|date|before_or_equal:today',
            'phone' => 'nullable|string|max:25',
            'address' => 'nullable|string|max:1000',
        ]);

        foreach ([
            'document_type',
            'document_number',
            'birth_date',
            'phone',
            'address',
        ] as $field) {
            $data[$field] = $data[$field] ?: null;
        }

        if ($patient) {
            $patient->update($data);
            $message = 'Paciente actualizado correctamente.';
        } else {
            Patient::create($data);
            $message = 'Paciente registrado correctamente.';
        }

        session()->flash('success', $message);

        return $this->redirectRoute('patients.index');
    }

    public function render()
    {
        return view('livewire.patients.patient-form');
    }
}

