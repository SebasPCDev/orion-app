@props(['payment'])

@php
    $statusColors = [
        'pagado' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
        'pendiente' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        'pending' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        'completed' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
    ];
    $statusColor = $statusColors[$payment->status] ?? 'bg-gray-50 text-gray-700 dark:bg-gray-700 dark:text-gray-400';
@endphp

<div class="group flex items-center gap-4 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
    {{-- Mobile Layout --}}
    <div class="sm:hidden flex-1">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $payment->apartment?->name ?? 'Sin propiedad' }}
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide {{ $statusColor }}">
                    {{ $payment->status }}
                </span>
            </div>
            <span class="text-sm font-bold text-gray-900 dark:text-white">
                ${{ number_format($payment->amount, 0, ',', '.') }}
            </span>
        </div>
        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span>{{ $payment->user?->name ?? 'Sin asignar' }}</span>
            <span>{{ $payment->month }} - {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</span>
        </div>
    </div>

    {{-- Desktop Layout --}}
    <div class="hidden sm:grid sm:grid-cols-12 gap-4 flex-1 items-center">
        {{-- Propiedad --}}
        <div class="col-span-3">
            <div class="flex items-center gap-2">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ $payment->apartment?->name ?? 'Sin propiedad' }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ $payment->apartment?->block ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Inquilino --}}
        <div class="col-span-2">
            @if($payment->user)
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-[10px] font-medium text-gray-600 dark:text-gray-300">
                            {{ $payment->user->initials() }}
                        </span>
                    </div>
                    <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                        {{ $payment->user->name }}
                    </span>
                </div>
            @else
                <span class="text-sm text-gray-400 dark:text-gray-500">Sin asignar</span>
            @endif
        </div>

        {{-- Monto --}}
        <div class="col-span-2">
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-gray-900 dark:text-white">
                    ${{ number_format($payment->amount, 0, ',', '.') }}
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide {{ $statusColor }}">
                    {{ $payment->status }}
                </span>
            </div>
        </div>

        {{-- Mes --}}
        <div class="col-span-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                {{ $payment->month }}
            </span>
        </div>

        {{-- Fecha --}}
        <div class="col-span-2">
            <p class="text-sm text-gray-700 dark:text-gray-300">
                {{ \Carbon\Carbon::parse($payment->payment_date)->locale('es')->isoFormat('D MMM YYYY') }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ \Carbon\Carbon::parse($payment->created_at)->diffForHumans() }}
            </p>
        </div>

        {{-- Actions --}}
        <div class="col-span-1 flex justify-end">
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:text-gray-300 dark:hover:bg-gray-700 opacity-0 group-hover:opacity-100 transition-all duration-150"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-1 w-36 rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                    style="display: none;"
                >
                    <button
                        wire:click="deletePayment({{ $payment->id }})"
                        wire:confirm="Estas seguro de eliminar este pago de ${{ number_format($payment->amount, 0, ',', '.') }}?"
                        @click="open = false"
                        class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Actions --}}
    <div class="sm:hidden">
        <button
            wire:click="deletePayment({{ $payment->id }})"
            wire:confirm="Estas seguro de eliminar este pago?"
            class="p-2 text-gray-400 hover:text-red-500 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    </div>
</div>
