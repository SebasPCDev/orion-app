<?php

use App\Livewire\ApartmentsComponent;
use App\Livewire\EditApartmentComponent;
use App\Livewire\Settings;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', Settings\Profile::class)->name('profile');
    Route::get('apartments', ApartmentsComponent::class)->name('apartments.index');
    Route::get('apartments/{apartment}/edit', EditApartmentComponent::class)->name('apartments.edit');

    Route::view('settings', 'settings.profile')->name('settings.profile');
    Route::view('settings/password', 'settings.password')->name('settings.password');
    Route::view('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
