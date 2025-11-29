<?php

namespace App\Livewire;

use App\Enums\LeaseStatus;
use App\Models\Apartment;
use App\Models\Lease;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Contratos')]
class LeasesComponent extends Component
{
    public string $search = '';
    public string $statusFilter = '';
    public string $apartmentFilter = '';
    public string $dateFrom = '';
    public string $dateTo = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'apartmentFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    #[Computed]
    public function leases(): Collection
    {
        return Lease::query()
            ->with(['apartment', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('apartment', function ($apartmentQuery) {
                        $apartmentQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->apartmentFilter, function ($query) {
                $query->where('apartment_id', $this->apartmentFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('start_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('start_date', '<=', $this->dateTo);
            })
            ->orderBy('start_date', 'desc')
            ->get();
    }

    #[Computed]
    public function stats(): array
    {
        $allLeases = Lease::select('status', 'monthly_rent')->get();
        $activeLeases = $allLeases->where('status', LeaseStatus::ACTIVE);
        $expiringSoon = Lease::expiringSoon(30)->count();

        return [
            'total' => $allLeases->count(),
            'active' => $activeLeases->count(),
            'completed' => $allLeases->where('status', LeaseStatus::COMPLETED)->count(),
            'terminated' => $allLeases->where('status', LeaseStatus::TERMINATED)->count(),
            'expiring_soon' => $expiringSoon,
            'monthly_income' => $activeLeases->sum('monthly_rent'),
        ];
    }

    #[Computed]
    public function apartments(): Collection
    {
        return Apartment::orderBy('name')->get(['id', 'name']);
    }

    #[Computed]
    public function statusOptions(): array
    {
        return [
            LeaseStatus::ACTIVE->value => 'Activos',
            LeaseStatus::COMPLETED->value => 'Completados',
            LeaseStatus::TERMINATED->value => 'Terminados',
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'apartmentFilter', 'dateFrom', 'dateTo']);
    }

    #[On('lease-created')]
    #[On('lease-terminated')]
    public function refresh(): void
    {
        unset($this->leases);
        unset($this->stats);
    }

    public function render(): View
    {
        return view('livewire.leases-component');
    }
}
