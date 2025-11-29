<?php

namespace App\Livewire;

use App\Models\Lease;
use Livewire\Attributes\On;
use Livewire\Component;

class LeaseDetailsModal extends Component
{
    public bool $show = false;
    public ?Lease $lease = null;

    #[On('open-lease-details-modal')]
    public function open($leaseId): void
    {
        $this->lease = Lease::with(['apartment', 'user', 'payments'])->findOrFail($leaseId);
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->lease = null;
    }

    public function terminateLease(): void
    {
        if ($this->lease) {
            $this->dispatch('open-terminate-lease-modal', leaseId: $this->lease->id);
            $this->close();
        }
    }

    public function render()
    {
        return view('livewire.lease-details-modal');
    }
}
