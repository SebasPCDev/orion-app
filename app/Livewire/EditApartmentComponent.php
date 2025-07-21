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

#[Layout('components.layouts.app')]
#[Title('Editar Apartamento')]
class EditApartmentComponent extends Component
{
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
    public string $status = 'available';

    // Payment properties
    public $amount;
    public $payment_date;
    public $payment_description;

    // Tenant properties
    public $tenant_id;

    public function mount($id): void
    {

        $this->apartment = Apartment::findOrFail($id);
        $this->fill($this->apartment->toArray());
        $this->amenities = is_array($this->apartment->amenities) ? $this->apartment->amenities : [];
        $this->tenant_id = $this->apartment->user_id;
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
            'status' => ['required', Rule::in(['available', 'rented', 'maintenance'])],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'payment_date' => ['nullable', 'date'],
            'payment_description' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            // ... add other apartment rules here if needed for specific validation
        ]);
        $this->apartment->update($this->only([
            'name', 'address', 'price', 'is_rented', 'block', 'description', 
            'bedrooms', 'bathrooms', 'area', 'floor', 'unit_number', 'amenities', 'status'
        ]));
        session()->flash('message', 'Apartamento actualizado exitosamente.');
        $this->redirectRoute('apartments.index', navigate: true);
    }
    
    public function addPayment()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_description' => 'nullable|string',
        ]);

        $this->apartment->payments()->create([
            'user_id' => Auth::id(),
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'description' => $this->payment_description,
            'status' => 'completed',
        ]);

        $this->reset(['amount', 'payment_date', 'payment_description']);
        $this->dispatch('payment-added');
    }

    public function markAsCompleted(Payment $payment)
    {
        $payment->update(['status' => 'completed']);
    }

    public function assignTenant()
    {
        $this->apartment->update(['user_id' => $this->tenant_id]);
        $this->dispatch('tenant-assigned');
    }

    public function render(): View
    {
        $allAmenities = ['Sala', 'Comedor', 'Cocina', 'Estacionamiento Moto'];
        $statusOptions = [
            'available' => 'Disponible',
            'rented' => 'Arrendado',
            'maintenance' => 'Mantenimiento',
        ];
        $payments = $this->apartment->payments()->orderBy('payment_date', 'desc')->get();
        $tenants = User::where('role', 'tenant')->orderBy('name')->get();

        return view('livewire.edit-apartment-component', [
            'allAmenities' => $allAmenities,
            'statusOptions' => $statusOptions,
            'payments' => $payments,
            'tenants' => $tenants,
        ]);
    }
}
