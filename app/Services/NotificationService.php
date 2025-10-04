<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class NotificationService
{
    /**
     * Flash a success toast notification
     */
    public static function success(string $title, ?string $text = null): void
    {
        Session::flash('swal', [
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
            'icon' => 'success',
            'title' => $title,
            'text' => $text,
        ]);
    }

    /**
     * Flash an error toast notification
     */
    public static function error(string $title, ?string $text = null): void
    {
        Session::flash('swal', [
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 4000,
            'timerProgressBar' => true,
            'icon' => 'error',
            'title' => $title,
            'text' => $text,
        ]);
    }

    /**
     * Flash a warning toast notification
     */
    public static function warning(string $title, ?string $text = null): void
    {
        Session::flash('swal', [
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3500,
            'timerProgressBar' => true,
            'icon' => 'warning',
            'title' => $title,
            'text' => $text,
        ]);
    }

    /**
     * Flash an info toast notification
     */
    public static function info(string $title, ?string $text = null): void
    {
        Session::flash('swal', [
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
            'icon' => 'info',
            'title' => $title,
            'text' => $text,
        ]);
    }

    /**
     * Flash a question toast notification
     */
    public static function question(string $title, ?string $text = null): void
    {
        Session::flash('swal', [
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
            'icon' => 'question',
            'title' => $title,
            'text' => $text,
        ]);
    }

    /**
     * Flash a custom toast notification
     */
    public static function custom(array $options): void
    {
        $defaultOptions = [
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timer' => 3000,
            'timerProgressBar' => true,
        ];

        Session::flash('swal', array_merge($defaultOptions, $options));
    }
}
