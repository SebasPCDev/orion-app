<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            </div>
        <flux:modal.trigger name="create-payment-modal">
            <flux:button variant="primary" size="sm">
                Registrar Pago
            </flux:button>
        </flux:modal.trigger>
    </div>

        {{-- Metrics Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Ingresos del Ano --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Ingresos {{ $currentYear }}</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($this->metrics['totalRevenue'], 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Meta: ${{ number_format($this->metrics['annualGoal'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            {{-- Progress Bar --}}
            <div class="mt-3">
                <div class="flex items-center justify-between text-xs mb-1">
                    <span class="text-gray-500 dark:text-gray-400">Progreso anual</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $this->metrics['progressPercentage'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $this->metrics['progressPercentage'] }}%"></div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
        </div>

            {{-- Pagos del Mes --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $currentMonth }}</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($this->metrics['currentMonthPayments'], 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-500"></div>
        </div>

            {{-- Total Transacciones --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Transacciones</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $this->metrics['totalPayments'] }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-violet-50 dark:bg-violet-900/30">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-violet-400 to-violet-500"></div>
        </div>

            {{-- Propiedades Arrendadas --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Arrendados</p>
                    <p class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $this->metrics['rentedCount'] }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
        </div>
    </div>

        {{-- Payments Section --}}
        <div class="space-y-4">
            {{-- Section Header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Historial de Pagos</h2>
            </div>

        {{-- Search & Filters --}}
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por propiedad, inquilino..." icon="magnifying-glass"/> 
            </div>

            {{-- Filter Buttons --}}
            <div class="flex items-center gap-2 flex-wrap">
                {{-- Month Filter --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg border transition-colors
                            {{ $monthFilter
                                ? 'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300'
                                : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $monthFilter ?: 'Mes' }}</span>
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-44 rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50 max-h-64 overflow-y-auto"
                        style="display: none;"
                    >
                        <button
                            wire:click="$set('monthFilter', '')"
                            @click="open = false"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ !$monthFilter ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        >
                            Todos los meses
                        </button>
                        @foreach($this->months as $month)
                            <button
                                wire:click="$set('monthFilter', '{{ $month }}')"
                                @click="open = false"
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $monthFilter === $month ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            >
                                {{ $month }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Apartment Filter --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg border transition-colors
                            {{ $apartmentFilter
                                ? 'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300'
                                : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="max-w-[100px] truncate">{{ $apartmentFilter ? $this->apartments->find($apartmentFilter)?->name : 'Propiedad' }}</span>
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-56 rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50 max-h-64 overflow-y-auto"
                        style="display: none;"
                    >
                        <button
                            wire:click="$set('apartmentFilter', '')"
                            @click="open = false"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ !$apartmentFilter ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        >
                            Todas las propiedades
                        </button>
                        @foreach($this->apartments as $apartment)
                            <button
                                wire:click="$set('apartmentFilter', '{{ $apartment->id }}')"
                                @click="open = false"
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 truncate {{ $apartmentFilter == $apartment->id ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            >
                                {{ $apartment->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Clear Filters --}}
                @if($search || $monthFilter || $apartmentFilter || $statusFilter)
                    <button
                        wire:click="clearFilters"
                        class="inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Limpiar
                    </button>
                @endif
            </div>
        </div>

        {{-- Results Summary --}}
        @if($search || $monthFilter || $apartmentFilter || $statusFilter)
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <span>Mostrando</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $this->payments->count() }}</span>
                <span>{{ $this->payments->count() === 1 ? 'pago' : 'pagos' }}</span>
            </div>
        @endif

            {{-- Payments Table --}}
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800">
                {{-- Table Header --}}
                <div class="hidden sm:grid sm:grid-cols-12 gap-4 px-6 py-3 bg-gray-50 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                <div class="col-span-3">Propiedad</div>
                <div class="col-span-2">Inquilino</div>
                <div class="col-span-2">Monto</div>
                <div class="col-span-2">Mes</div>
                <div class="col-span-2">Fecha</div>
                <div class="col-span-1"></div>
            </div>

            {{-- Payments List --}}
            @if($this->payments->count() > 0)
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @foreach($this->payments as $payment)
                        <x-payment-row :payment="$payment" />
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-16 px-4">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">No hay pagos registrados</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">
                        @if($search || $monthFilter || $apartmentFilter || $statusFilter)
                            No se encontraron pagos con los filtros seleccionados.
                        @else
                            Comienza registrando el primer pago del mes.
                        @endif
                    </p>
                    @if($search || $monthFilter || $apartmentFilter || $statusFilter)
                        <button
                            wire:click="clearFilters"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Limpiar filtros
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

        {{-- Create Payment Modal --}}
        <flux:modal name="create-payment-modal" class="md:w-[32rem]">
            <livewire:create-payment-modal :rentedApartments="$this->rentedApartments" />
        </flux:modal>
    </div>
</div>
