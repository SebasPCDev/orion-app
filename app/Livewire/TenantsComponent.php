<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\WithToastNotifications;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class TenantsComponent extends Component
{
    use WithToastNotifications;

    // Filters
    public string $search = '';
    public string $paymentStatusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'paymentStatusFilter' => ['except' => ''],
    ];

    #[Computed]
    public function tenants()
    {
        $tenants = User::query()
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
            ->orderBy('name')
            ->get();

        // Filter by calculated payment status if needed
        if ($this->paymentStatusFilter) {
            $tenants = $tenants->filter(function ($tenant) {
                return $tenant->payment_status_calculated === $this->paymentStatusFilter;
            });
        }

        return $tenants;
    }

    #[Computed]
    public function stats(): array
    {
        $tenants = User::where('role', 'tenant')->with('apartment')->get();

        return [
            'total' => $tenants->count(),
            'alDia' => $tenants->filter(fn($t) => $t->payment_status_calculated === 'al_dia')->count(),
            'pendientes' => $tenants->filter(fn($t) => $t->payment_status_calculated === 'pendiente')->count(),
            'morosos' => $tenants->filter(fn($t) => $t->payment_status_calculated === 'moroso')->count(),
            'sinAsignar' => $tenants->filter(fn($t) => !$t->apartment)->count(),
        ];
    }

    public function getPaymentStatusesProperty(): array
    {
        return [
            'al_dia' => 'Al día',
            'pendiente' => 'Pendiente',
            'moroso' => 'Moroso',
        ];
    }

    public function openCreateModal(): void
    {
        $this->dispatch('open-create-tenant-modal');
    }

    #[On('tenant-created')]
    public function handleTenantCreated(): void
    {
        unset($this->tenants);
        unset($this->stats);
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'paymentStatusFilter']);
    }

    public function render()
    {
        return view('livewire.tenants-component');
    }
}
