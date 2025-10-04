<?php

namespace App\Livewire;

use App\Models\Apartment;
use App\Models\Payment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

class DashboardMetrics extends Component
{
    public $totalRevenue;
    public $annualGoal;
    public $totalPayments;
    public $currentMonthPayments;
    public $currentMonth;
    public $rentedApartments;

    public function mount()
    {
        // Establecer el locale a español para Carbon y obtener el mes en español
        Carbon::setLocale('es');
        $this->currentMonth = ucfirst(Carbon::now()->translatedFormat('F'));
        $this->loadMetrics();
    }

    #[On('paymentCreated')]
    public function loadMetrics()
    {
        $this->totalRevenue = Payment::whereYear('payment_date', 2025)->sum('amount');
        
        $this->rentedApartments = Apartment::where('is_rented', true)->get();
        $this->annualGoal = $this->rentedApartments->sum('price') * 12;

        $this->totalPayments = Payment::whereYear('payment_date', 2025)->count();
        
        $this->currentMonthPayments = Payment::whereYear('payment_date', 2025)
            ->where('month', $this->currentMonth)
            ->sum('amount');
    }

    public function render()
    {
        return view('livewire.dashboard-metrics');
    }
}
