<?php

namespace App\Livewire;

use App\Models\Apartment;
use App\Models\Payment;
use App\Models\User;
use App\Traits\WithToastNotifications;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;

class CreatePaymentModal extends Component
{
    use WithToastNotifications;
    public $apartment_id;
    public $tenant_name;
    public $amount;
    public $month;
    public $description;
    public $rentedApartments;

    public $apartments;

    public function getRemainingMonths()
    {
        $currentMonth = Carbon::now()->month;
        $months = [];

        // Array de nombres de meses en español
        $monthNames = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        // Generar meses desde el mes actual hasta diciembre
        for ($i = $currentMonth; $i <= 12; $i++) {
            $months[$monthNames[$i]] = $monthNames[$i];
        }

        return $months;
    }

    public function mount()
    {
        Carbon::setLocale('es');
        $this->apartments = $this->rentedApartments;
        $this->month = ucfirst(Carbon::now()->monthName);
        $this->updateDescription();

    }

    public function updatedApartmentId($value)
    {
        $selectedApartment = Apartment::find($value); 
        if ($selectedApartment && $selectedApartment->user) {
            $this->tenant_name = $selectedApartment->user->name;
            $this->amount = $selectedApartment->price;

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
        try {
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
            Flux::modals()->close('create-payment-modal');

            $this->toastSuccess(
                'Pago registrado exitosamente',
                'El pago de ' . number_format($this->amount, 0, ',', '.') . ' COP ha sido registrado.'
            );

            $this->reset(['apartment_id', 'tenant_name', 'amount', 'description']);


            $this->dispatch('pg:eventRefresh-payments-table-223sc3-table');
            $this->dispatch('$refresh');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->toastError(
                'Error de validación',
                'Por favor verifica los datos ingresados.'
            );
        } catch (\Exception $e) {
            $this->toastError(
                'Error al registrar el pago',
                'Ha ocurrido un error inesperado. Inténtalo nuevamente.'
            );
        }
 
    }

    public function render()
    {
        return view('livewire.create-payment-modal');
    }
}
