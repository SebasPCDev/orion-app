<?php

namespace App\Livewire;

use App\Models\Apartment;
use App\Models\Payment;
use App\Models\User;
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

    public function getRemainingMonths()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $months = [];
        
        // Array de nombres de meses en español
        $monthNames = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        // Generar meses desde el mes actual hasta diciembre
        for ($i = $currentMonth - 1; $i <= 12; $i++) {
            $months[$monthNames[$i]] = $monthNames[$i];
        }
        
        return $months;
    }

    public function mount()
    {
        Carbon::setLocale('es');
        $this->apartments = Apartment::where('is_rented', true)->with('user')->get();
        $this->month = ucfirst(Carbon::now()->monthName);
        $this->updateDescription();

    }

    public function updatedApartmentId($value)
    {
        sleep(1); // TODO: Remove this

        //Reset the amount

        $selectedApartment = Apartment::find($value); 
        if ($selectedApartment && $selectedApartment->user) {
            $this->tenant_name = $selectedApartment->user->name;
            $this->amount = $selectedApartment->price;

            //Validar si el apartamento ya tiene un pago para el mes actual
        // Validar si el apartamento ya tiene un pago para el mes actual usando el helper monthToSpanish
        if($selectedApartment->payments()->where('month', monthToSpanish(Carbon::now()->monthName))->exists()){
            $this->addError('existing-payment', 'CUIDADO: Ya existe un pago para este mes.');
        }

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
        //Process the amount
        $this->amount = str_replace('.', '', $this->amount);
        $this->amount = str_replace(',', '', $this->amount);
        $this->amount = intval($this->amount);

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

        User::find($selectedApartment->user_id)->update(['payment_status' => 'Al día']);

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
