<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Inquilinos</h1>
            </div>
            <flux:button wire:click="openCreateModal" variant="primary" size="sm">
                Nuevo Inquilino
            </flux:button>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Total --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $this->stats['total'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Al dia --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Al dia</p>
                        <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $this->stats['alDia'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Pendientes --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pendientes</p>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $this->stats['pendientes'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Morosos --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-50 dark:bg-red-900/30">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Morosos</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $this->stats['morosos'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Sin asignar --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-violet-50 dark:bg-violet-900/30">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sin Apto</p>
                        <p class="text-2xl font-bold text-violet-600 dark:text-violet-400">{{ $this->stats['sinAsignar'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre, cedula, telefono..." icon="magnifying-glass"/>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Payment Status Filter --}}
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border transition-colors
                                    {{ $paymentStatusFilter
                                        ? 'bg-blue-50 border-blue-200 text-blue-700'
                                        : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50' }}"
                            >
                                @if($paymentStatusFilter === 'al_dia')
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                @elseif($paymentStatusFilter === 'pendiente')
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                @elseif($paymentStatusFilter === 'moroso')
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                @endif
                                <span>{{ $this->paymentStatuses[$paymentStatusFilter] ?? 'Estado Pago' }}</span>
                                <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition
                                x-cloak
                                class="absolute right-0 mt-2 w-44 rounded-lg bg-white shadow-lg border border-gray-200 py-1 z-50"
                            >
                                <button
                                    wire:click="$set('paymentStatusFilter', '')"
                                    @click="open = false"
                                    class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 {{ !$paymentStatusFilter ? 'bg-gray-100' : '' }}"
                                >
                                    Todos
                                </button>
                                @foreach($this->paymentStatuses as $value => $label)
                                    <button
                                        wire:click="$set('paymentStatusFilter', '{{ $value }}')"
                                        @click="open = false"
                                        class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 {{ $paymentStatusFilter === $value ? 'bg-gray-100' : '' }}"
                                    >
                                        <span @class([
                                            'w-2 h-2 rounded-full',
                                            'bg-emerald-500' => $value === 'al_dia',
                                            'bg-amber-500' => $value === 'pendiente',
                                            'bg-red-500' => $value === 'moroso',
                                        ])></span>
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Clear Filters --}}
                        @if($search || $paymentStatusFilter)
                            <button
                                wire:click="clearFilters"
                                class="inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Limpiar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Results Summary --}}
        @if($search || $paymentStatusFilter)
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <span>Mostrando</span>
                <span class="font-medium text-gray-900">{{ $this->tenants->count() }}</span>
                <span>{{ $this->tenants->count() === 1 ? 'inquilino' : 'inquilinos' }}</span>
            </div>
        @endif

        {{-- Tenants Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            {{-- Table Header --}}
            <div class="hidden sm:grid sm:grid-cols-12 gap-4 px-6 py-3 bg-gray-50 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                <div class="col-span-3">Inquilino</div>
                <div class="col-span-2">Identificacion</div>
                <div class="col-span-2">Contacto</div>
                <div class="col-span-2">Propiedad</div>
                <div class="col-span-2">Fecha Corte</div>
                <div class="col-span-1">Estado</div>
            </div>

            {{-- Tenants List --}}
            @if($this->tenants->count() > 0)
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @foreach($this->tenants as $tenant)
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors items-center">
                            {{-- Tenant Info --}}
                            <div class="col-span-3 flex items-center gap-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-violet-100 text-violet-700 font-bold text-sm">
                                    {{ $tenant->initials() }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $tenant->name }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $tenant->email }}</p>
                                </div>
                            </div>

                            {{-- Identification --}}
                            <div class="col-span-2">
                                <p class="text-sm text-gray-900">{{ $tenant->identification_number ?? '-' }}</p>
                            </div>

                            {{-- Contact --}}
                            <div class="col-span-2">
                                <p class="text-sm text-gray-900">{{ $tenant->phone ?? '-' }}</p>
                                @if($tenant->backup_phone)
                                    <p class="text-xs text-gray-500">{{ $tenant->backup_phone }}</p>
                                @endif
                            </div>

                            {{-- Property --}}
                            <div class="col-span-2">
                                @if($tenant->apartment)
                                    <p class="text-sm text-gray-900">{{ $tenant->apartment->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $tenant->apartment->formatted_price }}/mes</p>
                                @else
                                    <span class="text-sm text-gray-400">Sin asignar</span>
                                @endif
                            </div>

                            {{-- Cutoff Date --}}
                            <div class="col-span-2">
                                @if($tenant->cutoff_day)
                                    <p class="text-sm text-gray-900">Dia {{ $tenant->cutoff_day }}</p>
                                    @if($tenant->getNextCutoffDate())
                                        <p class="text-xs text-gray-500">Proximo: {{ $tenant->getNextCutoffDate()->format('d M') }}</p>
                                    @endif
                                @else
                                    <span class="text-sm text-gray-400">No definido</span>
                                @endif
                            </div>

                            {{-- Payment Status --}}
                            <div class="col-span-1">
                                @if($tenant->payment_status_calculated)
                                    <span @class([
                                        'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium',
                                        'bg-emerald-100 text-emerald-700' => $tenant->payment_status_calculated === 'al_dia',
                                        'bg-amber-100 text-amber-700' => $tenant->payment_status_calculated === 'pendiente',
                                        'bg-red-100 text-red-700' => $tenant->payment_status_calculated === 'moroso',
                                    ])>
                                        {{ $tenant->payment_status_label }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        N/A
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-16 px-4">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">No se encontraron inquilinos</h3>
                    <p class="text-sm text-gray-500 text-center max-w-sm">
                        @if($search || $paymentStatusFilter)
                            No se encontraron inquilinos con los filtros seleccionados.
                        @else
                            No hay inquilinos registrados. Haz clic en "Nuevo Inquilino" para agregar uno.
                        @endif
                    </p>
                    @if($search || $paymentStatusFilter)
                        <button
                            wire:click="clearFilters"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Limpiar filtros
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Create Tenant Modal --}}
    <livewire:create-tenant-modal />
</div>
