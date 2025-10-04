@props([
    'apartment' => [],
    'width' => 'w-80',
    'height' => 'h-auto',
    'showActions' => true
])


<div class="group relative bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700 {{ $width }} {{ $height }}">
    <div class="p-6 h-full flex flex-col cursor-pointer" wire:navigate href="{{ route('apartments.edit', $apartment->id) }}">
        <!-- Header con nombre y estado -->
        <div class="flex items-start justify-between mb-4 gap-2">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                {{ $apartment->name }}
            </h3>
            <div class="text-xs px-2 py-1 rounded-full {{ $apartment->status_badge_class }} cursor-pointer">
                {{ $apartment->status_text }}
            </div>
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <div class="flex items-center text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-sm">{{ $apartment->address }}</span>
            </div>
        </div>

        <!-- Información adicional del apartamento -->
        @if($apartment->bedrooms || $apartment->bathrooms || $apartment->area)
            <div class="mb-4 flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                @if($apartment->bedrooms)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21v-4a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                        </svg>
                        {{ $apartment->bedrooms }} hab.
                    </div>
                @endif
                
                @if($apartment->bathrooms)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                        </svg>
                        {{ $apartment->bathrooms }} baños
                    </div>
                @endif
                
                @if($apartment->area)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                        {{ $apartment->area }}m²
                    </div>
                @endif
            </div>
        @endif

        <!-- Precio - Se mantiene al final con flex-grow para empujar hacia abajo -->
        <div class="flex items-center justify-between mt-auto">
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $apartment->formatted_price }}</span>
                <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">/mes</span>
            </div>
            
            <!-- Acciones adicionales (opcional) -->
            @if($showActions)
                <div class="flex space-x-2">
                    <button 
                        wire:click="editApartment({{ $apartment->id }})"
                        class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                        title="Editar apartamento"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button 
                        wire:click="deleteApartment({{ $apartment->id }})"
                        wire:confirm="¿Estás seguro de que deseas eliminar este apartamento?"
                        class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors"
                        title="Eliminar apartamento"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>