<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Gestionar Apartamento: {{ $name }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                {{ $address }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Columna Izquierda: Pagos e Inquilinos -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Asignar Inquilino</h2>
                    <div class="space-y-4">
                        <flux:select wire:model="tenant_id" label="Seleccionar Inquilino" wire:change="assignTenant">
                            <option value="">Sin asignar</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                            @endforeach
                        </flux:select>
                        <x-action-message on="tenant-assigned">
                            <span class="text-green-600 dark:text-green-400">¡Inquilino asignado!</span>
                        </x-action-message>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Registrar Nuevo Pago</h2>
                    <form wire:submit.prevent="addPayment" class="space-y-6">
                        <flux:input wire:model.defer="amount" label="Monto" type="number" step="0.01" placeholder="Ingrese el monto"/>
                        <flux:input wire:model.defer="payment_date" label="Fecha de Pago" type="date"/>
                        <flux:textarea wire:model.defer="payment_description" label="Descripción" placeholder="Descripción opcional del pago" rows="4"/>
                        <div class="flex items-center justify-between">
                            <flux:button type="submit" variant="primary">Agregar Pago</flux:button>
                            <x-action-message on="payment-added">
                                <span class="text-green-600 dark:text-green-400">¡Pago agregado!</span>
                            </x-action-message>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Columna Derecha: Detalles del Apartamento -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Editar Detalles</h2>
                        <flux:checkbox wire:model.defer="is_rented" label="¿Arrendado?" />
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input wire:model.defer="name" label="Nombre" type="text" required />
                        <flux:input wire:model.defer="address" label="Dirección" type="text" required />
                    </div>
                    <flux:input wire:model.defer="price" label="Precio" type="number" step="0.01" required />
                    <flux:input wire:model.defer="block" label="Bloque" type="text" />
                    <flux:textarea wire:model.defer="description" label="Descripción" rows="3" />
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <flux:input wire:model.defer="bedrooms" label="Habitaciones" type="number" min="0" />
                        <flux:input wire:model.defer="bathrooms" label="Baños" type="number" min="0" />
                        <flux:input wire:model.defer="area" label="Área (m²)" type="number" min="0" step="0.01" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input wire:model.defer="floor" label="Piso" type="text" />
                        <flux:input wire:model.defer="unit_number" label="Número de unidad" type="text" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amenidades</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allAmenities as $amenity)
                                <flux:checkbox wire:model.defer="amenities" value="{{ $amenity }}" label="{{ $amenity }}" />
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <flux:select wire:model.defer="status" label="Estado">
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>
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
