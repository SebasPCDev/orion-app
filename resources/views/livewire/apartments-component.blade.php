<div>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mis Apartamentos</h1>
            <flux:button variant="primary">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Apartamento
            </flux:button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Apartamentos</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Disponibles</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['available'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Arrendados</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['rented'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ingreso Mensual</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($stats['monthly_income'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <flux:input 
                wire:model.live.debounce.300ms="search"
                label="Buscar"
                placeholder="Buscar por nombre, dirección..."
            />

            <!-- Block Filter -->
            <flux:select wire:model.live="blockFilter" label="Bloque">
                <option value="">Todos los bloques</option>
                @foreach($blocks as $block)
                    <option value="{{ $block }}">{{ $block }}</option>
                @endforeach
            </flux:select>

            <!-- Status Filter -->
            <flux:select wire:model.live="statusFilter" label="Estado">
                <option value="">Todos los estados</option>
                <option value="available">Disponibles</option>
                <option value="rented">Arrendados</option>
            </flux:select>
        </div>
    </div>

    <!-- Apartments by Block -->
    @if($apartmentsByBlock->count() > 0)
        @foreach($apartmentsByBlock as $block => $apartments)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $block }}</h2>
                    <div class="flex items-center bg-purple-100 dark:bg-purple-900 rounded-lg px-4 py-2">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <span class="text-lg font-semibold text-purple-700 dark:text-purple-300">
                            ${{ number_format($apartments->sum('price'), 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-purple-600 dark:text-purple-400 ml-1">/mes</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($apartments as $apartment)
                        <div class="group relative bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <!-- Header con nombre y estado -->
                                <div class="flex items-start justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                                        {{ $apartment->name }}
                                    </h3>
                                    <div class="flex space-x-2">
                                        <button 
                                            wire:click="toggleRentStatus({{ $apartment->id }})"
                                            class="text-xs px-2 py-1 rounded-full {{ $apartment->status_badge_class }} hover:opacity-80 transition-opacity"
                                        >
                                            {{ $apartment->status_text }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Dirección -->
                                <div class="mb-4">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $apartment->address }}</span>
                                    </div>
                                </div>

                                <!-- Precio -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-baseline">
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $apartment->formatted_price }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">/mes</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-2">
                                    <flux:button 
                                        wire:navigate
                                        href="{{ route('apartments.edit', $apartment->id) }}"
                                        variant="primary"
                                        class="flex-1">
                                        Editar
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No se encontraron apartamentos</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Intenta ajustar los filtros de búsqueda.
            </p>
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif
</div>
