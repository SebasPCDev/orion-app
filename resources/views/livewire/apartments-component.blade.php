<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Propiedades</h1>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-500"></div>
            </div>

            {{-- Disponibles --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Disponibles</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['available'] }}</p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
            </div>

            {{-- Arrendados --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Arrendados</p>
                        <p class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['rented'] }}</p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
            </div>

            {{-- Mantenimiento --}}
            <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Mantenimiento</p>
                        <p class="mt-1 text-2xl font-bold text-gray-600 dark:text-gray-400">{{ $stats['maintenance'] }}</p>
                    </div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-50 dark:bg-gray-900/30">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 8L13 11L10 10L6 6L5 3L8 0L11 1L15 5L16 8Z" fill="#000000"></path> <path d="M0 13L5.08579 7.91418L8.08579 10.9142L3 16L0 13Z" fill="#000000"></path> </g></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gray-400 to-gray-500"></div>
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
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre, direccion..." icon="magnifying-glass"/> 
            </div>

            {{-- Filter Buttons --}}
            <div class="flex items-center gap-2">
                {{-- Block Filter --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg border transition-colors
                            {{ $blockFilter
                                ? 'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300'
                                : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>{{ $blockFilter ?: 'Bloque' }}</span>
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                        style="display: none;"
                    >
                        <button
                            wire:click="$set('blockFilter', '')"
                            @click="open = false"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ !$blockFilter ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        >
                            Todos los bloques
                        </button>
                        @foreach($blocks as $block)
                            <button
                                wire:click="$set('blockFilter', '{{ $block }}')"
                                @click="open = false"
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $blockFilter === $block ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            >
                                {{ $block }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg border transition-colors
                            {{ $statusFilter
                                ? 'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300'
                                : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                    >
                        @if($statusFilter === 'available')
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        @elseif($statusFilter === 'rented')
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        @endif
                        <span>{{ $statusFilter === 'available' ? 'Disponibles' : ($statusFilter === 'rented' ? 'Arrendados' : 'Estado') }}</span>
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-40 rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                        style="display: none;"
                    >
                        <button
                            wire:click="$set('statusFilter', '')"
                            @click="open = false"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ !$statusFilter ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        >
                            Todos
                        </button>
                        <button
                            wire:click="$set('statusFilter', 'available')"
                            @click="open = false"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $statusFilter === 'available' ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        >
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Disponibles
                        </button>
                        <button
                            wire:click="$set('statusFilter', 'rented')"
                            @click="open = false"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $statusFilter === 'rented' ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                        >
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            Arrendados
                        </button>
                    </div>
                </div>

                {{-- Clear Filters --}}
                @if($search || $blockFilter || $statusFilter)
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
        @if($search || $blockFilter || $statusFilter)
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <span>Mostrando</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $this->apartments->count() }}</span>
                <span>{{ $this->apartments->count() === 1 ? 'resultado' : 'resultados' }}</span>
            </div>
        @endif

        {{-- Apartments by Block --}}
        @if($apartmentsByBlock->count() > 0)
            <div class="space-y-4">
                @foreach($apartmentsByBlock as $block => $apartments)
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800">
                        {{-- Block Header --}}
                        <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-white dark:bg-gray-700 shadow-sm border border-gray-200 dark:border-gray-600">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $block }}</h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $apartments->count() }} {{ $apartments->count() === 1 ? 'propiedad' : 'propiedades' }}
                                        <span class="mx-1 opacity-30">|</span>
                                        {{ $apartments->where('status', \App\Enums\ApartmentStatus::RENTED)->count() }} arrendados
                                        <span class="mx-1 opacity-30">|</span>
                                        {{ $apartments->where('status', \App\Enums\ApartmentStatus::MAINTENANCE)->count() }} mantenimiento
                                        <span class="mx-1 opacity-30">|</span>
                                        {{ $apartments->where('status', \App\Enums\ApartmentStatus::AVAILABLE)->count() }} disponibles
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <span class="text-xs text-gray-500 dark:text-gray-400">Ingreso:</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">${{ number_format($apartments->where('status', \App\Enums\ApartmentStatus::RENTED)->sum('price'), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Apartments List --}}
                        <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach($apartments as $apartment)
                                <x-apartment-card :apartment="$apartment" :show-actions="false" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="flex flex-col items-center justify-center py-16 px-4">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">No se encontraron propiedades</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">
                        @if($search || $blockFilter || $statusFilter)
                            Intenta ajustar los filtros de busqueda para ver mas resultados.
                        @else
                            Comienza agregando tu primera propiedad al portafolio.
                        @endif
                    </p>
                    @if($search || $blockFilter || $statusFilter)
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
            </div>
        @endif
    </div>
</div>
