<?php

namespace App\Livewire;

use App\Models\Apartment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Traits\WithToastNotifications;

#[Layout('components.layouts.app')]
#[Title('Editar Apartamento')]
class EditApartmentComponent extends Component
{
    use WithToastNotifications;
    public Apartment $apartment;

    // Apartment properties
    public string $name = '';
    public string $address = '';
    public $price = '';
    public bool $is_rented = false;
    public ?string $block = '';
    public ?string $description = '';
    public $bedrooms = '';
    public $bathrooms = '';
    public $area = '';
    public ?string $floor = '';
    public ?string $unit_number = '';
    public array $amenities = [];
    public array $images = []; // Agregar esta propiedad
    public string $status = 'available';

    // Payment properties
    public $amount;
    public $payment_date;
    public $payment_month;
    public $payment_description;

    // Tenant properties
    public $tenant_id;

    public function mount($id): void
    {

        $this->apartment = Apartment::findOrFail($id);
        $this->fill($this->apartment->toArray());
        $this->amenities = is_array($this->apartment->amenities) ? $this->apartment->amenities : [];        
        $this->tenant_id = $this->apartment->user_id;
        $this->images = is_array($this->apartment->images) ? $this->apartment->images : [];
    }


    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_rented' => ['boolean'],
            'block' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'floor' => ['nullable', 'string', 'max:50'],
            'unit_number' => ['nullable', 'string', 'max:50'],
            'amenities' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
            'status' => ['required', Rule::in(['available', 'rented', 'maintenance'])],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'payment_date' => ['nullable', 'date'],
            'payment_month' => ['nullable', 'string'],
            'payment_description' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        //Procesar precio
        $this->price = str_replace('.', '', $this->price);
        $this->price = str_replace(',', '', $this->price);
        $this->price = intval($this->price);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
        $this->apartment->update($this->only([
            'name', 'address', 'price', 'is_rented', 'block', 'description', 
            'bedrooms', 'bathrooms', 'area', 'floor', 'unit_number', 'amenities', 'images', 'status'
        ]));
        
        $this->toastSuccess(
            'Apartamento actualizado exitosamente',
            'El apartamento ha sido actualizado.'
        );
    }

    public function assignTenant()
    {
        $this->apartment->update(['user_id' => $this->tenant_id]);
        $this->dispatch('tenant-assigned');
    }

    public function vacateApartment(): void
    {
        $tenant = $this->apartment->user;

        if (!$tenant) {
            $this->toastError('Error', 'No hay inquilino asignado a este apartamento.');
            return;
        }

        // Update tenant status to inactive
        $tenant->update(['status' => 'inactive']);

        // Update apartment: remove tenant and set as available
        $this->apartment->update([
            'user_id' => null,
            'status' => 'available',
            'is_rented' => false,
        ]);

        // Refresh local state
        $this->tenant_id = null;
        $this->status = 'available';
        $this->is_rented = false;

        $this->dispatch('apartment-vacated');
        $this->toastSuccess(
            'Apartamento desocupado',
            "El inquilino {$tenant->name} ha sido desvinculado y el apartamento está disponible."
        );
    }

    public function hasPendingPayments(): bool
    {
        return $this->apartment->payments()
            ->where('status', 'pending')
            ->exists();
    }

    public function render(): View
    {
        $allAmenities = ['Sala', 'Comedor', 'Cocina', 'Estacionamiento Moto'];
        $statusOptions = [
            'available' => 'Disponible',
            'rented' => 'Arrendado',
            'maintenance' => 'Mantenimiento',
        ];
        $payments = $this->apartment->payments()->with('user')->orderBy('payment_date', 'desc')->get();
        $tenants = User::where('role', 'tenant')->orderBy('name')->get();

        return view('livewire.edit-apartment-component', [
            'allAmenities' => $allAmenities,
            'statusOptions' => $statusOptions,
            'payments' => $payments,
            'tenants' => $tenants,
        ]);
    }
}

