<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\WithToastNotifications;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateTenantModal extends Component
{
    use WithToastNotifications;

    public bool $show = false;

    // Form fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $backup_phone = '';
    public string $identification_number = '';
    public ?int $cutoff_day = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'backup_phone' => ['nullable', 'string', 'max:20'],
            'identification_number' => ['required', 'string', 'max:50', 'unique:users,identification_number'],
            'cutoff_day' => ['required', 'integer', 'min:1', 'max:31'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'phone.required' => 'El teléfono es requerido.',
            'identification_number.required' => 'El número de identificación es requerido.',
            'identification_number.unique' => 'Este número de identificación ya está registrado.',
            'cutoff_day.required' => 'La fecha de corte es requerida.',
            'cutoff_day.min' => 'El día debe ser entre 1 y 31.',
            'cutoff_day.max' => 'El día debe ser entre 1 y 31.',
        ];
    }

    #[On('open-create-tenant-modal')]
    public function open(): void
    {
        $this->reset(['name', 'email', 'phone', 'backup_phone', 'identification_number', 'cutoff_day']);
        $this->resetValidation();
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
    }

    public function save(): void
    {
        $this->validate();

        // Generate a temporary password
        $temporaryPassword = Str::random(10);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'backup_phone' => $this->backup_phone ?: null,
            'identification_number' => $this->identification_number,
            'cutoff_day' => $this->cutoff_day,
            'password' => Hash::make($temporaryPassword),
            'role' => 'tenant',
            'status' => 'active',
        ]);

        $this->close();
        $this->dispatch('tenant-created');
        $this->toastSuccess(
            'Inquilino registrado',
            "Se ha creado el inquilino {$this->name}. Contraseña temporal: {$temporaryPassword}"
        );
    }

    public function render()
    {
        return view('livewire.create-tenant-modal');
    }
}
