<?php

if (!function_exists('toast_success')) {
    function toast_success(string $title, ?string $text = null): void
    {
        \App\Services\NotificationService::success($title, $text);
    }
}

if (!function_exists('toast_error')) {
    function toast_error(string $title, ?string $text = null): void
    {
        \App\Services\NotificationService::error($title, $text);
    }
}

if (!function_exists('toast_warning')) {
    function toast_warning(string $title, ?string $text = null): void
    {
        \App\Services\NotificationService::warning($title, $text);
    }
}

if (!function_exists('toast_info')) {
    function toast_info(string $title, ?string $text = null): void
    {
        \App\Services\NotificationService::info($title, $text);
    }
}

if (!function_exists('toast_question')) {
    function toast_question(string $title, ?string $text = null): void
    {
        \App\Services\NotificationService::question($title, $text);
    }
}