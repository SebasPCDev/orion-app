<?php

namespace App\Livewire;

use App\Models\Lease;
use App\Traits\WithToastNotifications;
use Livewire\Attributes\On;
use Livewire\Component;

class TerminateLeaseModal extends Component
{
    use WithToastNotifications;

    public bool $show = false;
    public ?Lease $lease = null;
    public string $reason = 'terminated';
    public string $notes = '';

    #[On('open-terminate-lease-modal')]
    public function open($leaseId): void
    {
        $this->lease = Lease::with(['apartment', 'user'])->findOrFail($leaseId);
        $this->reason = 'terminated';
        $this->notes = '';
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->lease = null;
        $this->reset(['reason', 'notes']);
    }

    public function terminate(): void
    {
        if (!$this->lease) {
            return;
        }

        $apartmentName = $this->lease->apartment->name;
        $userName = $this->lease->user->name;

        // Use the terminate method from Lease model
        $this->lease->terminate($this->reason, $this->notes);

        $this->close();
        $this->dispatch('lease-terminated');

        $this->toastSuccess(
            'Contrato terminado',
            "El contrato de {$apartmentName} con {$userName} ha sido terminado."
        );
    }

    public function render()
    {
        return view('livewire.terminate-lease-modal');
    }
}
