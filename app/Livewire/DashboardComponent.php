<?php

namespace App\Livewire;

use App\Models\Apartment;
use App\Models\Payment;
use App\Models\User;
use App\Traits\WithToastNotifications;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardComponent extends Component
{
    use WithToastNotifications;

    // Filters
    public string $search = '';
    public string $monthFilter = '';
    public string $apartmentFilter = '';
    public string $statusFilter = '';

    // Metrics
    public $currentMonth;
    public $currentYear;

    protected $queryString = [
        'search' => ['except' => ''],
        'monthFilter' => ['except' => ''],
        'apartmentFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function mount()
    {
        Carbon::setLocale('es');
        $this->currentMonth = ucfirst(Carbon::now()->translatedFormat('F'));
        $this->currentYear = Carbon::now()->year;
    }

    #[Computed]
    public function metrics(): array
    {
        $totalRevenue = Payment::whereYear('payment_date', $this->currentYear)->sum('amount');
        $rentedApartments = Apartment::where('is_rented', true)->get();
        $annualGoal = $rentedApartments->sum('price') * 12;
        $totalPayments = Payment::whereYear('payment_date', $this->currentYear)->count();
        $currentMonthPayments = Payment::whereYear('payment_date', $this->currentYear)
            ->where('month', $this->currentMonth)
            ->sum('amount');

        // Calcular progreso anual
        $progressPercentage = $annualGoal > 0 ? round(($totalRevenue / $annualGoal) * 100, 1) : 0;

        return [
            'totalRevenue' => $totalRevenue,
            'annualGoal' => $annualGoal,
            'totalPayments' => $totalPayments,
            'currentMonthPayments' => $currentMonthPayments,
            'rentedCount' => $rentedApartments->count(),
            'progressPercentage' => min($progressPercentage, 100),
        ];
    }

    #[Computed]
    public function payments()
    {
        return Payment::query()
            ->with(['apartment', 'user'])
            ->when($this->search, function ($query) {
                $query->whereHas('apartment', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->monthFilter, function ($query) {
                $query->where('month', $this->monthFilter);
            })
            ->when($this->apartmentFilter, function ($query) {
                $query->where('apartment_id', $this->apartmentFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('payment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    #[Computed]
    public function apartments()
    {
        return Apartment::orderBy('name')->get();
    }

    #[Computed]
    public function rentedApartments()
    {
        return Apartment::where('is_rented', true)->orderBy('name')->get();
    }

    public function getMonthsProperty(): array
    {
        return [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'monthFilter', 'apartmentFilter', 'statusFilter']);
    }

    public function deletePayment($paymentId): void
    {
        $payment = Payment::find($paymentId);

        if ($payment) {
            $amount = $payment->amount;
            $month = $payment->month;
            $payment->delete();

            $this->toastSuccess(
                'Pago eliminado',
                "El pago de $" . number_format($amount, 0, ',', '.') . " del mes de {$month} ha sido eliminado."
            );
        } else {
            $this->toastError(
                'Error',
                'No se encontro el pago a eliminar.'
            );
        }
    }

    #[On('paymentCreated')]
    public function refreshData(): void
    {
        unset($this->metrics);
        unset($this->payments);
    }

    public function render()
    {
        return view('livewire.dashboard-component');
    }
}
