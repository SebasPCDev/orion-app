<?php

namespace App\Traits;

use SweetAlert2\Laravel\Traits\WithSweetAlert;

trait WithToastNotifications
{
    use WithSweetAlert;

    /**
     * Show a success toast notification
     */
    public function toastSuccess(string $title, ?string $text = null): void
    {
        $this->swalFire([
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 5000,
            'timerProgressBar' => true,
            'icon' => 'success',
            'title' => $title,
            'text' => $text,
            'didOpen' => '(toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }',
        ]);
    }

    /**
     * Show an error toast notification
     */
    public function toastError(string $title, ?string $text = null): void
    {
        $this->swalFire([
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 4000,
            'timerProgressBar' => true,
            'icon' => 'error',
            'title' => $title,
            'text' => $text,
            'didOpen' => '(toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }',
        ]);
    }

    /**
     * Show a warning toast notification
     */
    public function toastWarning(string $title, ?string $text = null): void
    {
        $this->swalFire([
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3500,
            'timerProgressBar' => true,
            'icon' => 'warning',
            'title' => $title,
            'text' => $text,
            'didOpen' => '(toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }',
        ]);
    }

    /**
     * Show an info toast notification
     */
    public function toastInfo(string $title, ?string $text = null): void
    {
        $this->swalFire([
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
            'icon' => 'info',
            'title' => $title,
            'text' => $text,
            'didOpen' => '(toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }',
        ]);
    }

    /**
     * Show a question toast notification
     */
    public function toastQuestion(string $title, ?string $text = null): void
    {
        $this->swalFire([
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
            'icon' => 'question',
            'title' => $title,
            'text' => $text,
            'didOpen' => '(toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }',
        ]);
    }

    /**
     * Show a custom toast notification
     */
    public function toastCustom(array $options): void
    {
        $defaultOptions = [
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
            'didOpen' => '(toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }',
        ];

        $this->swalFire(array_merge($defaultOptions, $options));
    }
}
