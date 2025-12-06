<?php

namespace App\Livewire;

use App\Enums\ApartmentStatus;
use App\Enums\LeaseStatus;
use App\Models\Apartment;
use App\Models\Lease;
use App\Models\User;
use App\Traits\WithToastNotifications;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Enums\UserStatus;

class CreateLeaseModal extends Component
{
    use WithToastNotifications;

    public bool $show = false;

    // Form fields
    public ?int $apartment_id = null;
    public ?int $user_id = null;
    public $monthly_rent = '';
    public int $cutoff_day;
    public string $start_date = '';
    public string $end_date = '';
    public string $notes = '';

    protected function rules(): array
    {
        return [
            'apartment_id' => ['required', 'exists:apartments,id'],
            'user_id' => ['required', 'exists:users,id'],
            'monthly_rent' => ['required', 'integer', 'min:0'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'apartment_id.required' => 'Debe seleccionar un apartamento.',
            'apartment_id.exists' => 'El apartamento seleccionado no es válido.',
            'user_id.required' => 'Debe seleccionar un inquilino.',
            'user_id.exists' => 'El inquilino seleccionado no es válido.',
            'monthly_rent.required' => 'La renta mensual es requerida.',
            'monthly_rent.integer' => 'La renta debe ser un número entero.',
            'monthly_rent.min' => 'La renta debe ser mayor a 0.',
            'cutoff_day.required' => 'El día de corte es requerido.',
            'cutoff_day.min' => 'El día debe estar entre 1 y 31.',
            'cutoff_day.max' => 'El día debe estar entre 1 y 31.',
            'start_date.required' => 'La fecha de inicio es requerida.',
            'start_date.date' => 'Debe ser una fecha válida.',
            'start_date.after_or_equal' => 'La fecha de inicio no puede ser en el pasado.',
            'end_date.date' => 'Debe ser una fecha válida.',
            'end_date.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'notes.max' => 'Las notas no pueden exceder 1000 caracteres.',
        ];
    }

    #[Computed]
    public function availableApartments(): Collection
    {
        return Apartment::where('status', ApartmentStatus::AVAILABLE)
            ->orderBy('block')
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function tenants(): Collection
    {
        return User::where('role', 'tenant')
            ->where('status', UserStatus::AVAILABLE->value())
            ->orderBy('name')
            ->get();
    }

    public function updatedApartmentId($value): void
    {
        if ($value) {
            $apartment = Apartment::find($value);
            if ($apartment) {
                // Pre-fill monthly rent with apartment price
                $this->monthly_rent = $apartment->price;
            }
        }
    }

    public function updatedUserId($value): void
    {
        if ($value) {
            $user = User::find($value);
            if ($user && $user->cutoff_day) {
                // Pre-fill cutoff day with user's cutoff day
                $this->cutoff_day = $user->cutoff_day;
            }
        }
    }

    #[On('open-create-lease-modal')]
    public function open(): void
    {
        $this->reset(['apartment_id', 'user_id', 'monthly_rent', 'start_date', 'notes']);
        $this->cutoff_day = 1;
        $this->start_date = Carbon::today()->format('Y-m-d');
        $this->resetValidation();
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
    }

    public function save(): void
    {
        // Process monthly_rent
        $this->monthly_rent = str_replace(['.', ','], '', $this->monthly_rent);
        $this->monthly_rent = intval($this->monthly_rent);

        $this->validate();

        // Check if apartment already has active lease
        $existingLease = Lease::where('apartment_id', $this->apartment_id)
            ->where('status', LeaseStatus::ACTIVE)
            ->first();

        if ($existingLease) {
            $this->toastError(
                'Error',
                'Este apartamento ya tiene un contrato activo.'
            );
            return;
        }

        // Calculate cutoff day
        $this->cutoff_day = date('d', strtotime($this->start_date));

        //Calculate end date
        $this->end_date = date('Y-m-d', strtotime($this->start_date . ' + 1 year'));

        // Create lease
        $lease = Lease::create([
            'apartment_id' => $this->apartment_id,
            'user_id' => $this->user_id,
            'monthly_rent' => $this->monthly_rent,
            'cutoff_day' => $this->cutoff_day,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date ?: null,
            'status' => LeaseStatus::ACTIVE,
            'notes' => $this->notes,
        ]);

        // Update apartment
        $apartment = Apartment::find($this->apartment_id);
        $apartment->update([
            'user_id' => $this->user_id,
            'status' => ApartmentStatus::RENTED,
        ]);

        // Update user status to active
        $user = User::find($this->user_id);
        $user->update([
            'status' => 'active',
        ]);

        $this->close();
        $this->dispatch('lease-created');

        $this->toastSuccess(
            'Contrato creado',
            "Se ha creado el contrato para {$apartment->name} con {$user->name}."
        );
    }

    public function render()
    {
        return view('livewire.create-lease-modal');
    }
}
