<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class PatientList extends Component
{
    use WithPagination;

    public string $search = '';

    public function mount(): void
    {
        Gate::authorize('viewAny', Patient::class);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        Gate::authorize('viewAny', Patient::class);

        $patients = Patient::query()
            ->where(function ($query) {
                $query->where(
                    'first_name',
                    'ilike',
                    '%' . $this->search . '%'
                )
                ->orWhere(
                    'last_name',
                    'ilike',
                    '%' . $this->search . '%'
                )
                ->orWhere(
                    'document_number',
                    'ilike',
                    '%' . $this->search . '%'
                );
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(10);

        return view('livewire.patients.patient-list', [
            'patients' => $patients,
        ]);
    }
}

