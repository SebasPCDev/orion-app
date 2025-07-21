<?php

use App\Livewire\ApartmentsComponent;
use App\Livewire\EditApartmentComponent;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('apartments', ApartmentsComponent::class)->name('apartments.index');
    Route::get('apartments/{id}/edit', EditApartmentComponent::class)->name('apartments.edit');
    Route::get('pagos', function () {
        return view('livewire.payments-page');
    })->name('payments.index');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
