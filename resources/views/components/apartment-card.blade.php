@props([
    'name' => 'Apartamento Ejemplo',
    'address' => 'Calle Ejemplo 123, Ciudad',
    'price' => 500000,
    'isRented' => false,
    'href' => '#'
])

<div class="group relative bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
    <a href="{{ $href }}" target="_blank" class="block p-6">
        <!-- Header con nombre y estado -->
        <div class="flex items-start justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                {{ $name }}
            </h3>
        </div>
        <div class="flex items-center justify-between mb-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isRented ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                {{ $isRented ? 'Arrendado' : 'Disponible' }}
            </span>
        </div>
        <!-- Dirección -->
        <div class="mb-4">
            <div class="flex items-center text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-sm">{{ $address }}</span>
            </div>
        </div>

        <!-- Precio -->
        <div class="flex items-center justify-between">
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($price, 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">/mes</span>
            </div>
            
            <!-- Icono de flecha para indicar que es clickeable -->
            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </div>
        </div>

        <!-- Overlay hover effect -->
        <div class="absolute inset-0 bg-blue-500 opacity-0 group-hover:opacity-5 transition-opacity duration-300 pointer-events-none"></div>
    </a>
</div> 