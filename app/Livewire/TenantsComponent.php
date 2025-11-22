<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\WithToastNotifications;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TenantsComponent extends Component
{
    use WithToastNotifications;

    // Filters
    public string $search = '';
    public string $paymentStatusFilter = '';
    public string $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'paymentStatusFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    #[Computed]
    public function tenants()
    {
        return User::query()
            ->where('role', 'tenant')
            ->with('apartment')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('identification_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->paymentStatusFilter, function ($query) {
                $query->where('payment_status', $this->paymentStatusFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function stats(): array
    {
        $tenants = User::where('role', 'tenant')->get();

        return [
            'total' => $tenants->count(),
            'alDia' => $tenants->where('payment_status', 'Al día')->count(),
            'enRetraso' => $tenants->where('payment_status', 'Retraso')->count(),
            'morosos' => $tenants->where('payment_status', 'Moroso')->count(),
        ];
    }

    public function getPaymentStatusesProperty(): array
    {
        return ['Al día', 'Retraso', 'Moroso'];
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'paymentStatusFilter', 'statusFilter']);
    }

    public function render()
    {
        return view('livewire.tenants-component');
    }
}
