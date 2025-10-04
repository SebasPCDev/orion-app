<?php

namespace App\Livewire;

use App\Traits\WithToastNotifications;
use Livewire\Component;
use Livewire\Attributes\On;

class ToastManager extends Component
{
    use WithToastNotifications;

    #[On('toast-success')]
    public function handleToastSuccess($data): void
    {
        $this->toastSuccess($data['title'], $data['text'] ?? null);
    }

    #[On('toast-error')]
    public function handleToastError($data): void
    {
        $this->toastError($data['title'], $data['text'] ?? null);
    }

    #[On('toast-warning')]
    public function handleToastWarning($data): void
    {
        $this->toastWarning($data['title'], $data['text'] ?? null);
    }

    #[On('toast-info')]
    public function handleToastInfo($data): void
    {
        $this->toastInfo($data['title'], $data['text'] ?? null);
    }

    #[On('toast-question')]
    public function handleToastQuestion($data): void
    {
        $this->toastQuestion($data['title'], $data['text'] ?? null);
    }

    #[On('toast-custom')]
    public function handleToastCustom($data): void
    {
        $this->toastCustom($data);
    }

    public function render()
    {
        return view('livewire.toast-manager');
    }
}
