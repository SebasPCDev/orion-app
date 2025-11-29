<?php

namespace App\Livewire;

use App\Enums\ApartmentStatus;
use App\Models\Apartment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ApartmentsComponent extends Component
{
    public string $search = '';
    public string $blockFilter = '';
    public string $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'blockFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    protected $listeners = [
        'apartmentUpdated' => '$refresh',
        'apartmentCreated' => '$refresh',
        'apartmentDeleted' => '$refresh',
    ];

    public function mount(): void
    {
        // Inicialización del componente si es necesario
        // Por ejemplo, validar permisos, configurar valores por defecto, etc.
    }

    #[Computed]
    public function apartments(): Collection
    {
        return Apartment::query()
            ->with(['user', 'activeLease'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->blockFilter, function ($query) {
                $query->where('block', $this->blockFilter);
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'available') {
                    $query->where('status', ApartmentStatus::AVAILABLE);
                } elseif ($this->statusFilter === 'rented') {
                    $query->where('status', ApartmentStatus::RENTED);
                }
            })
            ->orderBy('block')
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function apartmentsByBlock(): Collection
    {
        return $this->apartments->groupBy('block');
    }

    #[Computed]
    public function blocks(): Collection
    {
        return Apartment::distinct()
            ->pluck('block')
            ->filter()
            ->sort()
            ->values();
    }

    #[Computed]
    public function stats(): array
    {
        // Optimización: usar una sola query para obtener todas las estadísticas
        $allApartments = Apartment::with('activeLease')->get();

        // Calculate monthly income from active leases, not reference prices
        $monthlyIncome = $allApartments
            ->filter(fn($apt) => $apt->status === ApartmentStatus::RENTED && $apt->activeLease)
            ->sum(fn($apt) => $apt->activeLease->monthly_rent);

        return [
            'total' => $allApartments->count(),
            'available' => $allApartments->where('status', ApartmentStatus::AVAILABLE)->count(),
            'rented' => $allApartments->where('status', ApartmentStatus::RENTED)->count(),
            'maintenance' => $allApartments->where('status', ApartmentStatus::MAINTENANCE)->count(),
            'monthly_income' => $monthlyIncome,
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'blockFilter', 'statusFilter']);
    }

    public function updatedSearch(): void
    {
        // Se ejecuta cuando cambia el search
        // Útil para analytics o logging
    }

    public function updatedBlockFilter(): void
    {
        // Se ejecuta cuando cambia el filtro de bloque
    }

    public function updatedStatusFilter(): void
    {
        // Se ejecuta cuando cambia el filtro de estado
    }

    public function render(): View
    {
        return view('livewire.apartments-component', [
            'apartmentsByBlock' => $this->apartmentsByBlock,
            'blocks' => $this->blocks,
            'stats' => $this->stats,
        ]);
    }
}
