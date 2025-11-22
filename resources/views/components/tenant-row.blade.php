@props(['tenant'])

@php
    $paymentStatusColors = [
        'Al día' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
        'Retraso' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        'Moroso' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    ];
    $paymentStatusColor = $paymentStatusColors[$tenant->payment_status] ?? 'bg-gray-50 text-gray-700 dark:bg-gray-700 dark:text-gray-400';

    $statusDot = [
        'Al día' => 'bg-emerald-500',
        'Retraso' => 'bg-amber-500',
        'Moroso' => 'bg-red-500',
    ];
    $dotColor = $statusDot[$tenant->payment_status] ?? 'bg-gray-400';
@endphp

<div class="group flex items-center gap-4 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
    {{-- Mobile Layout --}}
    <div class="sm:hidden flex-1">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center flex-shrink-0">
                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                    {{ $tenant->initials() }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                        {{ $tenant->name }}
                    </h3>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ $paymentStatusColor }}">
                        {{ $tenant->payment_status }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $tenant->phone ?? 'Sin telefono' }}
                </p>
            </div>
        </div>
        @if($tenant->apartment)
            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 pl-13">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span>{{ $tenant->apartment->name }}</span>
            </div>
        @endif
    </div>

    {{-- Desktop Layout --}}
    <div class="hidden sm:grid sm:grid-cols-12 gap-4 flex-1 items-center">
        {{-- Inquilino --}}
        <div class="col-span-3">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center">
                        <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                            {{ $tenant->initials() }}
                        </span>
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white dark:border-gray-800 {{ $dotColor }}"></div>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ $tenant->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ $tenant->email ?? 'Sin email' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Identificacion --}}
        <div class="col-span-2">
            <span class="text-sm text-gray-700 dark:text-gray-300 font-mono">
                {{ $tenant->identification_number ?? '-' }}
            </span>
        </div>

        {{-- Contacto --}}
        <div class="col-span-2">
            <div class="space-y-1">
                @if($tenant->phone)
                    <div class="flex items-center gap-1.5 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>{{ $tenant->phone }}</span>
                    </div>
                @endif
                @if($tenant->backup_phone)
                    <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>{{ $tenant->backup_phone }}</span>
                    </div>
                @endif
                @if(!$tenant->phone && !$tenant->backup_phone)
                    <span class="text-sm text-gray-400 dark:text-gray-500">Sin contacto</span>
                @endif
            </div>
        </div>

        {{-- Propiedad --}}
        <div class="col-span-3">
            @if($tenant->apartment)
                <div class="flex items-center gap-2">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $tenant->apartment->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ $tenant->apartment->block ?? $tenant->apartment->address }}
                        </p>
                    </div>
                </div>
            @else
                <span class="text-sm text-gray-400 dark:text-gray-500">Sin propiedad asignada</span>
            @endif
        </div>

        {{-- Estado de Pago --}}
        <div class="col-span-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $paymentStatusColor }}">
                {{ $tenant->payment_status }}
            </span>
        </div>
    </div>
</div>
