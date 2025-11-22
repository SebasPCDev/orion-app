<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Inquilinos</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gestiona los inquilinos de tus propiedades</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        {{-- Total --}}
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $this->stats['total'] }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-500"></div>
        </div>

        {{-- Al dia --}}
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Al dia</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $this->stats['alDia'] }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
        </div>

        {{-- En retraso --}}
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">En Retraso</p>
                    <p class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $this->stats['enRetraso'] }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
        </div>

        {{-- Morosos --}}
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Morosos</p>
                    <p class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400">{{ $this->stats['morosos'] }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-50 dark:bg-red-900/30">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-red-400 to-red-500"></div>
        </div>
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
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar por nombre, cedula, telefono..."
                class="block w-full pl-9 pr-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
            >
        </div>

        {{-- Filter Buttons --}}
        <div class="flex items-center gap-2 flex-wrap">
            {{-- Payment Status Filter --}}
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg border transition-colors
                        {{ $paymentStatusFilter
                            ? 'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300'
                            : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                >
                    @if($paymentStatusFilter === 'Al día')
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    @elseif($paymentStatusFilter === 'Retraso')
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    @elseif($paymentStatusFilter === 'Moroso')
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                    <span>{{ $paymentStatusFilter ?: 'Estado Pago' }}</span>
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-40 rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                    style="display: none;"
                >
                    <button
                        wire:click="$set('paymentStatusFilter', '')"
                        @click="open = false"
                        class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ !$paymentStatusFilter ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    >
                        Todos
                    </button>
                    <button
                        wire:click="$set('paymentStatusFilter', 'Al día')"
                        @click="open = false"
                        class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $paymentStatusFilter === 'Al día' ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    >
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Al dia
                    </button>
                    <button
                        wire:click="$set('paymentStatusFilter', 'Retraso')"
                        @click="open = false"
                        class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $paymentStatusFilter === 'Retraso' ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    >
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        En Retraso
                    </button>
                    <button
                        wire:click="$set('paymentStatusFilter', 'Moroso')"
                        @click="open = false"
                        class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $paymentStatusFilter === 'Moroso' ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                    >
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        Moroso
                    </button>
                </div>
            </div>

            {{-- Clear Filters --}}
            @if($search || $paymentStatusFilter || $statusFilter)
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
    @if($search || $paymentStatusFilter || $statusFilter)
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <span>Mostrando</span>
            <span class="font-medium text-gray-900 dark:text-white">{{ $this->tenants->count() }}</span>
            <span>{{ $this->tenants->count() === 1 ? 'inquilino' : 'inquilinos' }}</span>
        </div>
    @endif

    {{-- Tenants Table --}}
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800">
        {{-- Table Header --}}
        <div class="hidden sm:grid sm:grid-cols-12 gap-4 px-4 py-3 bg-gray-50 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700 text-[10px] font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
            <div class="col-span-3">Inquilino</div>
            <div class="col-span-2">Identificacion</div>
            <div class="col-span-2">Contacto</div>
            <div class="col-span-3">Propiedad</div>
            <div class="col-span-2">Estado Pago</div>
        </div>

        {{-- Tenants List --}}
        @if($this->tenants->count() > 0)
            <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                @foreach($this->tenants as $tenant)
                    <x-tenant-row :tenant="$tenant" />
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-16 px-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">No se encontraron inquilinos</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">
                    @if($search || $paymentStatusFilter || $statusFilter)
                        No se encontraron inquilinos con los filtros seleccionados.
                    @else
                        No hay inquilinos registrados en el sistema.
                    @endif
                </p>
                @if($search || $paymentStatusFilter || $statusFilter)
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
