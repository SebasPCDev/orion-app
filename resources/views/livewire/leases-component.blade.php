<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Contratos</h1>
            </div>
            <flux:button wire:click="$dispatch('open-create-lease-modal')" variant="primary" size="sm">
                Nuevo Contrato
            </flux:button>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Contratos --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Total
                        </p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $this->stats['total'] }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-500"></div>
            </div>

            {{-- Activos --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Activos
                        </p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $this->stats['active'] }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
            </div>

            {{-- Por Vencer --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Por Vencer (30d)
                        </p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $this->stats['expiring_soon'] }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
            </div>

            {{-- Ingreso Mensual --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Ingreso Mensual
                        </p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($this->stats['monthly_income'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-violet-50 dark:bg-violet-900/30">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-violet-400 to-violet-500"></div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por apartamento o inquilino..." icon="magnifying-glass"/> 
            </div>

            {{-- Status Filter --}}
            <select
                wire:model.live="statusFilter"
                class="block w-full sm:w-40 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
            >
                <option value="">Todos los estados</option>
                @foreach($this->statusOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            {{-- Apartment Filter --}}
            <select
                wire:model.live="apartmentFilter"
                class="block w-full sm:w-48 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
            >
                <option value="">Todos los apartamentos</option>
                @foreach($this->apartments as $apartment)
                    <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
                @endforeach
            </select>

            {{-- Clear Filters --}}
            @if($search || $statusFilter || $apartmentFilter || $dateFrom || $dateTo)
                <button
                    wire:click="clearFilters"
                    class="inline-flex items-center justify-center px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                >
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Limpiar
                </button>
            @endif
        </div>

        {{-- Leases Table --}}
        @if($this->leases->count() > 0)
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800">
                {{-- Table Header (Desktop) --}}
                <div class="hidden sm:grid sm:grid-cols-12 gap-4 px-6 py-3 bg-gray-50 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    <div class="col-span-3">Apartamento</div>
                    <div class="col-span-3">Inquilino</div>
                    <div class="col-span-2">Renta Mensual</div>
                    <div class="col-span-2">Fecha Inicio</div>
                    <div class="col-span-2">Estado</div>
                </div>

                {{-- Table Body --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @foreach($this->leases as $lease)
                        <div
                            wire:click="$dispatch('open-lease-details-modal', { leaseId: {{ $lease->id }} })"
                            class="grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-4 px-4 sm:px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer"
                        >
                            {{-- Apartamento --}}
                            <div class="sm:col-span-3">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $lease->apartment->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $lease->apartment->block }}
                                </div>
                            </div>

                            {{-- Inquilino --}}
                            <div class="sm:col-span-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                            {{ $lease->user->initials() }}
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $lease->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Corte día {{ $lease->cutoff_day }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Renta Mensual --}}
                            <div class="sm:col-span-2">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $lease->formatted_monthly_rent }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    /mes
                                </div>
                            </div>

                            {{-- Fecha Inicio --}}
                            <div class="sm:col-span-2">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $lease->start_date->format('d/m/Y') }}
                                </div>
                                @if($lease->end_date)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Fin: {{ $lease->end_date->format('d/m/Y') }}
                                    </div>
                                @else
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Indefinido
                                    </div>
                                @endif
                            </div>

                            {{-- Estado --}}
                            <div class="sm:col-span-2">
                                <span @class([
                                    'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium uppercase tracking-wide',
                                    $lease->status_badge_class
                                ])>
                                    {{ $lease->status_text }}
                                </span>
                                @if($lease->isActive() && $lease->end_date)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $lease->start_date->diffInDays($lease->end_date) }} días
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">No hay contratos</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">
                    @if($search || $statusFilter || $apartmentFilter)
                        No se encontraron contratos con los filtros aplicados.
                    @else
                        Aún no hay contratos registrados. Crea tu primer contrato para comenzar.
                    @endif
                </p>
                @if($search || $statusFilter || $apartmentFilter)
                    <button
                        wire:click="clearFilters"
                        class="mt-4 inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors"
                    >
                        Limpiar filtros
                    </button>
                @endif
            </div>
        @endif
    </div>

    {{-- Modals --}}
    <livewire:create-lease-modal />
    <livewire:lease-details-modal />
    <livewire:terminate-lease-modal />
</div>
