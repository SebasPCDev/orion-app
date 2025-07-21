<?php

namespace App\Livewire;

use App\Models\Apartment;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Mis Apartamentos')]
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

    public function render(): View
    {
        $apartments = Apartment::query()
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
                    $query->where('is_rented', false);
                } elseif ($this->statusFilter === 'rented') {
                    $query->where('is_rented', true);
                }
            })
            ->orderBy('block')
            ->orderBy('name')
            ->get();

        // Group apartments by block
        $apartmentsByBlock = $apartments->groupBy('block');
        
        $blocks = Apartment::distinct()->pluck('block')->filter()->sort()->values();
        
        $stats = [
            'total' => Apartment::count(),
            'available' => Apartment::where('is_rented', false)->count(),
            'rented' => Apartment::where('is_rented', true)->count(),
            'monthly_income' => Apartment::sum('price'),
        ];

        return view('livewire.apartments-component', [
            'apartmentsByBlock' => $apartmentsByBlock,
            'blocks' => $blocks,
            'stats' => $stats,
        ]);
    }

    public function deleteApartment(Apartment $apartment): void
    {
        $apartment->delete();
        session()->flash('message', 'Apartamento eliminado exitosamente.');
    }

    public function toggleRentStatus(Apartment $apartment): void
    {
        $apartment->update([
            'is_rented' => !$apartment->is_rented,
            'status' => !$apartment->is_rented ? 'rented' : 'available'
        ]);
        
        session()->flash('message', 'Estado del apartamento actualizado.');
    }
}
