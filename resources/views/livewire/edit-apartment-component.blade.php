<div class="flex-1 self-stretch max-md:pt-6" x-data="apartmentEditController()" @apartment-saved.window="handleSaveSuccess()">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Header con navegación --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('apartments.index') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-zinc-200 text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-zinc-900">{{ $name }}</h1>
                    <p class="text-zinc-500 mt-0.5">{{ $address }}</p>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Indicador de cambios --}}
                    <span x-show="editMode && detectChanges()"
                          x-cloak
                          class="text-xs px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full font-medium">
                        Cambios sin guardar
                    </span>
                    {{-- Toggle de edición --}}
                    <button
                        type="button"
                        @click="toggleEditMode()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                        :class="editMode
                            ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm'
                            : 'bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50 shadow-sm'"
                    >
                        <svg x-show="!editMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <svg x-show="editMode" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span x-text="editMode ? 'Cancelar' : 'Editar'"></span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            {{-- Precio --}}
            <div class="bg-white rounded-xl border border-zinc-200 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-50">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Precio de Referencia</p>
                        <p class="text-lg font-bold text-zinc-900">${{ number_format((int) str_replace(['.', ','], '', $price), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Estado --}}
            <div class="bg-white rounded-xl border border-zinc-200 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ $status === 'rented' ? 'bg-blue-50' : ($status === 'available' ? 'bg-green-50' : 'bg-amber-50') }}">
                        <svg class="w-5 h-5 {{ $status === 'rented' ? 'text-blue-600' : ($status === 'available' ? 'text-green-600' : 'text-amber-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Estado</p>
                        <p class="text-lg font-bold text-zinc-900">{{ $statusOptions[$status] ?? 'Desconocido' }}</p>
                    </div>
                </div>
            </div>

            {{-- Inquilino --}}
            <div class="bg-white rounded-xl border border-zinc-200 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ $apartment->user ? 'bg-violet-50' : 'bg-zinc-100' }}">
                        <svg class="w-5 h-5 {{ $apartment->user ? 'text-violet-600' : 'text-zinc-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Inquilino</p>
                        <p class="text-lg font-bold text-zinc-900">{{ $apartment->user?->name ?? 'Sin asignar' }}</p>
                    </div>
                </div>
            </div>

            {{-- Características --}}
            <div class="bg-white rounded-xl border border-zinc-200 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cyan-50">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Características</p>
                        <p class="text-lg font-bold text-zinc-900">{{ $bedrooms ?? 0 }} hab. / {{ $bathrooms ?? 0 }} baños</p>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-4">
            {{-- Galería de Imágenes --}}
            <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-100">
                    <h2 class="text-base font-semibold text-zinc-900">Galería de Imágenes</h2>
                </div>
                <div class="p-6">
                    @if(!empty($images))
                        <div x-data="{ selectedImage: '{{ $images[0] ?? '' }}', showModal: false }">
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                @foreach($images as $index => $image)
                                    <div class="relative aspect-[4/3] group cursor-pointer overflow-hidden rounded-lg border border-zinc-200"
                                            @click="selectedImage = '{{ $image }}'; showModal = true">
                                        <img src="{{ $image }}"
                                                alt="Imagen {{ $index + 1 }}"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                                loading="lazy">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                            </svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Modal --}}
                            <div x-show="showModal"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                                    @click="showModal = false"
                                    @keydown.escape.window="showModal = false">
                                <div class="relative max-w-5xl w-full" @click.stop>
                                    <img :src="selectedImage"
                                            alt="Vista ampliada"
                                            class="w-full h-auto max-h-[85vh] object-contain rounded-lg">
                                    <button @click="showModal = false"
                                            class="absolute -top-3 -right-3 w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-lg text-zinc-600 hover:text-zinc-900 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 mb-4">
                                <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-zinc-900 mb-1">Sin imágenes</h3>
                            <p class="text-sm text-zinc-500">Agrega fotografías del inmueble</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Asignar Inquilino --}}
            <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-100">
                    <h2 class="text-base font-semibold text-zinc-900">Inquilino Asignado</h2>
                </div>
                <div class="p-6">
                    @if($apartment->user)
                        <div class="flex items-center gap-4 p-4 bg-zinc-50 rounded-lg mb-4">
                            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-violet-100 text-violet-700 font-bold text-lg">
                                {{ substr($apartment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-zinc-900 truncate">{{ $apartment->user->name }}</p>
                                <p class="text-sm text-zinc-500 truncate">{{ $apartment->user->email }}</p>
                                @if($apartment->user->phone)
                                    <p class="text-sm text-zinc-500 truncate">{{ $apartment->user->phone }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Botón Desocupar --}}
                        <div x-data="{ showConfirm: false }" class="mt-4">
                            <button
                                type="button"
                                @click="showConfirm = true"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Desocupar Apartamento
                            </button>

                            {{-- Modal de confirmación --}}
                            <div x-show="showConfirm"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                 @keydown.escape.window="showConfirm = false">
                                <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6" @click.stop>
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-zinc-900">Confirmar desocupación</h3>
                                    </div>

                                    <p class="text-sm text-zinc-600 mb-4">
                                        Esta acción desvinculará al inquilino <strong>{{ $apartment->user->name }}</strong> de este apartamento y cambiará su estado a inactivo.
                                    </p>

                                    @if($this->hasPendingPayments())
                                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg mb-4">
                                            <div class="flex items-center gap-2 text-amber-800">
                                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                <span class="text-sm font-medium">Este apartamento tiene pagos pendientes</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex justify-end gap-3">
                                        <flux:button type="button" variant="ghost" @click="showConfirm = false">
                                            Cancelar
                                        </flux:button>
                                        <flux:button
                                            type="button"
                                            variant="danger"
                                            wire:click="vacateApartment"
                                            @click="showConfirm = false"
                                        >
                                            Confirmar Desocupación
                                        </flux:button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 mb-4">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-zinc-100 mb-3">
                                <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-zinc-500">Sin inquilino asignado</p>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @if($apartment->status === 'available')
                            <flux:select wire:model="tenant_id" label="Seleccionar inquilino">
                                <option value="">-- Sin asignar --</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                @endforeach
                            </flux:select>
                            <flux:button wire:click="assignTenant" variant="primary" class="w-full">
                                Actualizar Inquilino
                            </flux:button>
                        @elseif($apartment->status === 'maintenance')
                            <p class="text-sm text-zinc-500">El apartamento está en mantenimiento y no se puede asignar un inquilino</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-semibold text-zinc-900">Información del Inmueble</h2>
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium"
                                  :class="editMode ? 'bg-blue-100 text-blue-700' : 'bg-zinc-100 text-zinc-600'"
                                  x-text="editMode ? 'Editando' : 'Solo lectura'">
                            </span>
                        </div>
                    </div>
                    <form wire:submit.prevent="save" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input wire:model.defer="name" label="Nombre" type="text" required x-bind:disabled="!editMode"/>
                            <flux:input wire:model.defer="address" label="Dirección" type="text" required x-bind:disabled="!editMode"/>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <flux:input icon="currency-dollar" label="Precio de Referencia" x-mask:dynamic="$money($input)" wire:model.defer="price" required x-bind:disabled="!editMode"/>
                                <p class="mt-1 text-xs text-zinc-500">Este es el precio sugerido. El precio real se define en el contrato.</p>
                            </div>
                            <flux:input wire:model.defer="block" label="Bloque" type="text" x-bind:disabled="!editMode"/>
                            <flux:select wire:model.defer="status" label="Estado" x-bind:disabled="!editMode">
                                @foreach($statusOptions as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <flux:input wire:model.defer="bedrooms" label="Habitaciones" type="number" min="0" x-bind:disabled="!editMode"/>
                            <flux:input wire:model.defer="bathrooms" label="Baños" type="number" min="0" x-bind:disabled="!editMode"/>
                            <flux:input wire:model.defer="area" label="Área (m²)" type="number" min="0" step="0.01" x-bind:disabled="!editMode"/>
                            <flux:input wire:model.defer="floor" label="Piso" type="text" x-bind:disabled="!editMode"/>
                            <flux:input wire:model.defer="unit_number" label="Unidad" type="text" x-bind:disabled="!editMode"/>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-3">Amenidades</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($allAmenities as $amenity)
                                    <flux:checkbox wire:model.defer="amenities" value="{{ $amenity }}" label="{{ $amenity }}" x-bind:disabled="!editMode"/>
                                @endforeach
                            </div>
                        </div>

                        <flux:textarea wire:model.defer="description" label="Descripción" rows="3" x-bind:disabled="!editMode"/>

                        <div x-show="editMode" x-cloak class="flex justify-end pt-4 border-t border-zinc-100">
                            <flux:button
                                type="submit"
                                variant="primary"
                                @click="setTimeout(() => { editMode = false; }, 100)"
                            >
                                Guardar Cambios
                            </flux:button>
                        </div>
                    </form>
                </div>

        {{-- Historial de Pagos --}}
        <div class="mt-8 bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
                <h2 class="text-base font-semibold text-zinc-900">Historial de Pagos</h2>
                <span class="text-sm text-zinc-500">{{ $payments->count() }} {{ $payments->count() === 1 ? 'pago' : 'pagos' }}</span>
            </div>

            @if($payments->count() > 0)
                <div class="divide-y divide-zinc-100">
                    @foreach ($payments as $payment)
                        <div class="px-6 py-4 hover:bg-zinc-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ $payment->status === 'pagado' ? 'bg-emerald-100' : 'bg-amber-100' }}">
                                        <svg class="w-5 h-5 {{ $payment->status === 'pagado' ? 'text-emerald-600' : 'text-amber-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($payment->status === 'pagado')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-zinc-900">${{ number_format($payment->amount, 2) }}</span>
                                            @if($payment->month)
                                                <span class="text-xs px-2 py-0.5 bg-zinc-100 text-zinc-600 rounded-full">{{ $payment->month }}</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-zinc-500">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}
                                            @if($payment->user)
                                                <span class="mx-1">·</span> {{ $payment->user->name }}
                                            @endif
                                        </p>
                                        @if($payment->description)
                                            <p class="text-sm text-zinc-600 mt-1">{{ $payment->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($payment->status === 'pending')
                                        <button wire:click="markAsCompleted({{ $payment->id }})"
                                                class="text-xs px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition-colors font-medium">
                                            Marcar pagado
                                        </button>
                                    @else
                                        <span class="text-xs px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg font-medium">
                                            Pagado
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 mb-4">
                        <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-zinc-900 mb-1">Sin pagos registrados</h3>
                    <p class="text-sm text-zinc-500">Los pagos aparecerán aquí cuando se registren</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function apartmentEditController() {
        return {
            editMode: false,
            originalValues: {},

            init() {
                this.$watch('editMode', value => {
                    if (value) {
                        setTimeout(() => this.captureOriginalValues(), 50);
                    }
                });
            },

            captureOriginalValues() {
                this.originalValues = {
                    name: this.$wire.name,
                    address: this.$wire.address,
                    price: this.$wire.price,
                    block: this.$wire.block,
                    bedrooms: this.$wire.bedrooms,
                    bathrooms: this.$wire.bathrooms,
                    area: this.$wire.area,
                    floor: this.$wire.floor,
                    unit_number: this.$wire.unit_number,
                    description: this.$wire.description,
                    status: this.$wire.status,
                    amenities: [...this.$wire.amenities]
                };
            },

            detectChanges() {
                const current = {
                    name: this.$wire.name,
                    address: this.$wire.address,
                    price: this.$wire.price,
                    block: this.$wire.block,
                    bedrooms: this.$wire.bedrooms,
                    bathrooms: this.$wire.bathrooms,
                    area: this.$wire.area,
                    floor: this.$wire.floor,
                    unit_number: this.$wire.unit_number,
                    description: this.$wire.description,
                    status: this.$wire.status,
                    amenities: [...this.$wire.amenities]
                };

                for (let key in this.originalValues) {
                    if (key === 'amenities') {
                        if (JSON.stringify(this.originalValues[key].sort()) !== JSON.stringify(current[key].sort())) {
                            return true;
                        }
                    } else {
                        if (this.originalValues[key] != current[key]) {
                            return true;
                        }
                    }
                }
                return false;
            },

            toggleEditMode() {
                if (this.editMode) {
                    if (this.detectChanges()) {
                        if (confirm('¿Deseas salir del modo edición? Los cambios no guardados se perderán.')) {
                            this.$wire.name = this.originalValues.name;
                            this.$wire.address = this.originalValues.address;
                            this.$wire.price = this.originalValues.price;
                            this.$wire.block = this.originalValues.block;
                            this.$wire.bedrooms = this.originalValues.bedrooms;
                            this.$wire.bathrooms = this.originalValues.bathrooms;
                            this.$wire.area = this.originalValues.area;
                            this.$wire.floor = this.originalValues.floor;
                            this.$wire.unit_number = this.originalValues.unit_number;
                            this.$wire.description = this.originalValues.description;
                            this.$wire.status = this.originalValues.status;
                            this.$wire.amenities = [...this.originalValues.amenities];
                            this.editMode = false;
                        }
                    } else {
                        this.editMode = false;
                    }
                } else {
                    this.captureOriginalValues();
                    this.editMode = true;
                }
            },

            handleSaveSuccess() {
                this.editMode = false;
                this.originalValues = {};
            }
        }
    }
</script>
