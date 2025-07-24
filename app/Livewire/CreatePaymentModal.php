<?php

namespace App\Livewire;

use App\Models\Apartment;
use App\Models\Payment;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreatePaymentModal extends Component
{
    public $apartment_id;
    public $tenant_name;
    public $amount;
    public $month;
    public $description;

    public $apartments;

    public function mount()
    {
        Carbon::setLocale('es');
        $this->apartments = Apartment::where('is_rented', true)->with('user')->get();
        $this->month = ucfirst(Carbon::now()->monthName);
        $this->updateDescription();
    }

    public function updatedApartmentId($value)
    {
        $selectedApartment = Apartment::find($value);
        if ($selectedApartment && $selectedApartment->user) {
            $this->tenant_name = $selectedApartment->user->name;
            $this->amount = $selectedApartment->price;
        } else {
            $this->tenant_name = '';
            $this->amount = '';
        }
    }

    public function updatedMonth()
    {
        $this->updateDescription();
    }

    public function updateDescription()
    {
        $this->description = "Pago de arriendo Mes ({$this->month})";
    }

    public function save()
    {
        $this->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'amount' => 'required|numeric',
            'month' => 'required|string',
        ]);


        $selectedApartment = Apartment::find($this->apartment_id);

        Payment::create([
            'apartment_id' => $this->apartment_id,
            'user_id' => $selectedApartment->user_id,
            'amount' => $this->amount,
            'payment_date' => now(),
            'month' => $this->month,
            'status' => 'pagado',
            'description' => $this->description,
        ]);

        $this->reset(['apartment_id', 'tenant_name', 'amount', 'description']);

        Flux::modals()->close('create-payment-modal');

        $this->dispatch('pg:eventRefresh-payments-table-223sc3-table');
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.create-payment-modal');
    }
}
