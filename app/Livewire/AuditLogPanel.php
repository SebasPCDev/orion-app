<?php

namespace App\Livewire;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Registro de Auditoría')]
class AuditLogPanel extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $model = '';

    #[Url]
    public string $event = '';

    #[Url]
    public string $userId = '';

    #[Url]
    public string $dateFrom = '';

    #[Url]
    public string $dateTo = '';

    public ?int $selectedLogId = null;

    /**
     * Available models for filtering.
     */
    #[Computed]
    public function availableModels(): array
    {
        return [
            'App\Models\Apartment' => 'Apartamentos',
            'App\Models\User' => 'Usuarios',
            'App\Models\Payment' => 'Pagos',
        ];
    }

    /**
     * Available events for filtering.
     */
    #[Computed]
    public function availableEvents(): array
    {
        return [
            'created' => 'Creado',
            'updated' => 'Actualizado',
            'deleted' => 'Eliminado',
        ];
    }

    /**
     * Get users for filter dropdown.
     */
    #[Computed]
    public function users(): \Illuminate\Database\Eloquent\Collection
    {
        return User::orderBy('name')->get(['id', 'name']);
    }

    /**
     * Get paginated audit logs.
     */
    #[Computed]
    public function logs()
    {
        return AuditLog::query()
            ->with(['user', 'auditable'])
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $q) {
                    $q->whereHas('user', function (Builder $userQuery) {
                        $userQuery->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhere('auditable_id', $this->search);
                });
            })
            ->when($this->model, function (Builder $query) {
                $query->forModel($this->model);
            })
            ->when($this->event, function (Builder $query) {
                $query->byEvent($this->event);
            })
            ->when($this->userId, function (Builder $query) {
                $query->byUser((int) $this->userId);
            })
            ->when($this->dateFrom || $this->dateTo, function (Builder $query) {
                $query->betweenDates($this->dateFrom, $this->dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * Get the selected log for detail view.
     */
    #[Computed]
    public function selectedLog(): ?AuditLog
    {
        if (!$this->selectedLogId) {
            return null;
        }

        return AuditLog::with(['user', 'auditable'])->find($this->selectedLogId);
    }

    /**
     * Get statistics for the dashboard cards.
     */
    #[Computed]
    public function stats(): array
    {
        $baseQuery = AuditLog::query();

        return [
            'total' => $baseQuery->count(),
            'today' => $baseQuery->clone()->whereDate('created_at', today())->count(),
            'created' => $baseQuery->clone()->byEvent('created')->count(),
            'updated' => $baseQuery->clone()->byEvent('updated')->count(),
            'deleted' => $baseQuery->clone()->byEvent('deleted')->count(),
        ];
    }

    /**
     * Reset all filters.
     */
    public function resetFilters(): void
    {
        $this->reset(['search', 'model', 'event', 'userId', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    /**
     * Show detail modal for a log.
     */
    public function showDetail(int $logId): void
    {
        $this->selectedLogId = $logId;
    }

    /**
     * Close detail modal.
     */
    public function closeDetail(): void
    {
        $this->selectedLogId = null;
    }

    /**
     * Translate field names to Spanish.
     */
    public function translateField(string $field): string
    {
        $translations = [
            'name' => 'Nombre',
            'address' => 'Dirección',
            'price' => 'Precio',
            'status' => 'Estado',
            'block' => 'Bloque',
            'description' => 'Descripción',
            'bedrooms' => 'Habitaciones',
            'bathrooms' => 'Baños',
            'area' => 'Área',
            'floor' => 'Piso',
            'unit_number' => 'Número de unidad',
            'amenities' => 'Amenidades',
            'images' => 'Imágenes',
            'user_id' => 'Inquilino',
            'email' => 'Correo electrónico',
            'phone' => 'Teléfono',
            'role' => 'Rol',
            'payment_status' => 'Estado de pago',
            'amount' => 'Monto',
            'payment_date' => 'Fecha de pago',
            'month' => 'Mes',
            'apartment_id' => 'Apartamento',
        ];

        return $translations[$field] ?? $field;
    }

    public function render(): View
    {
        return view('livewire.audit-log-panel');
    }
}
