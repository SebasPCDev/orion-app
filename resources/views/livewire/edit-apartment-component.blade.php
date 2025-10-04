<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $name }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                {{ $address }}
            </p>
        </div>

        <!-- Carousel de Imágenes -->
        <div class="mb-8">
            @if(!empty($images))
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Fotografías del Inmueble</h3>
                    
                    <!-- Contenedor del carousel con scroll horizontal -->
                    <div class="relative" x-data="{ 
                                selectedImage: '{{ $images[0] ?? '' }}',
                                showModal: false 
                            }">
                        <div 
                            class="flex flex-wrap gap-3 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-gray-100 dark:scrollbar-track-gray-800 pb-2"
                            style="scroll-behavior: smooth;"
                            
                        >
                            @foreach($images as $index => $image)
                                <div class="flex-shrink-0">
                                    <div 
                                        class="relative group cursor-pointer transition-all duration-200 hover:scale-105"
                                        @click="selectedImage = '{{ $image }}'; showModal = true"
                                    >
                                        <img 
                                            src="{{ $image }}" 
                                            alt="Imagen {{ $index + 1 }} del apartamento"
                                            class="w-32 h-24 object-cover rounded-lg shadow-md border-2 border-transparent group-hover:border-blue-500 dark:group-hover:border-blue-400"
                                            loading="lazy"
                                        >
                                        <!-- Overlay con efecto hover -->
                                        <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                            </svg>
                                        </div>
                                        <!-- Número de imagen -->
                                        <div class="absolute top-1 right-1 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Modal para vista ampliada -->
                        <div 
                            x-show="showModal" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
                            @click="showModal = false"
                            @keydown.escape.window="showModal = false"
                            style="display: none;"
                        >
                            <div class="relative max-w-4xl max-h-full p-4" @click.stop>
                                <img 
                                    :src="selectedImage" 
                                    alt="Vista ampliada"
                                    class="max-w-full max-h-full object-contain rounded-lg shadow-2xl"
                                >
                                <button 
                                    @click="showModal = false"
                                    class="absolute top-2 right-2 text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 transition-all duration-200"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay imágenes</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Agrega fotografías del inmueble para mostrarlas aquí.</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col items-start w-full">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 w-full">
                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información del Inmueble</h2>
                        <flux:checkbox wire:model.defer="is_rented" label="¿Arrendado?" disabled />
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <flux:input wire:model.defer="name" label="Nombre" type="text" required disabled/>
                        <flux:input wire:model.defer="address" label="Dirección" type="text" required disabled/>
                        <flux:input icon="currency-dollar" label="Precio" x-mask:dynamic="$money($input)" wire:model.defer="price" required disabled />
                        <flux:input wire:model.defer="block" label="Bloque" type="text"  disabled/>
                    </div>
                    <flux:textarea wire:model.defer="description" label="Descripción" rows="3" disabled/>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <flux:input wire:model.defer="bedrooms" label="Habitaciones" type="number" min="0" disabled />
                        <flux:input wire:model.defer="bathrooms" label="Baños" type="number" min="0" disabled />
                        <flux:input wire:model.defer="area" label="Área (m²)" type="number" min="0" step="0.01" disabled />
                        <flux:input wire:model.defer="floor" label="Piso" type="text" disabled />
                        <flux:input wire:model.defer="unit_number" label="Número de unidad" type="text" disabled />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amenidades</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allAmenities as $amenity)
                                <flux:checkbox wire:model.defer="amenities" value="{{ $amenity }}" label="{{ $amenity }}" disabled />
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <flux:select wire:model.defer="status" label="Estado" disabled>
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary" disabled>Guardar Cambios</flux:button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Historial de Pagos -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow">
             <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Historial de Pagos</h2>
            </div>
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($payments as $payment)
                    <li class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</p>
                                    @if($payment->status == 'pending')
                                        <button wire:click="markAsCompleted({{ $payment->id }})" class="ml-3 text-xs px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 hover:bg-yellow-200 transition-colors">Marcar como completado</button>
                                    @else
                                        <span class="ml-3 text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Completado</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Fecha: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d F, Y') }}
                                    @if($payment->user)
                                        <span class="text-gray-400 dark:text-gray-500 mx-1">|</span> Registrado por: {{ $payment->user->name }}
                                    @endif
                                </p>
                                @if($payment->description)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ $payment->description }}</p>
                                @endif
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="p-6 text-center">
                        <div class="mx-auto h-12 w-12 text-gray-400"><svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" /></svg></div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay pagos registrados</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Cuando registres un pago, aparecerá aquí.</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
