<div>
    @if($show)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                
            <div class="fixed inset-0 transition-opacity bg-zinc-500/75" wire:click="close"></div>

                {{-- Center modal --}}
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal panel --}}
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Nuevo Contrato
                            </h3>
                            <button
                                wire:click="close"
                                class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-4 space-y-4 max-h-[calc(100vh-16rem)] overflow-y-auto">
                        {{-- Apartamento --}}
                        <div>
                            <label for="apartment_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Apartamento <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="apartment_id"
                                wire:model.live="apartment_id"
                                class="block w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('apartment_id') border-red-500 @enderror"
                            >
                                <option value="">Seleccione un apartamento</option>
                                @foreach($this->availableApartments as $apartment)
                                    <option value="{{ $apartment->id }}">
                                        {{ $apartment->name }} - {{ $apartment->block }} (${{ number_format($apartment->price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('apartment_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Inquilino --}}
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Inquilino <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="user_id"
                                wire:model.live="user_id"
                                class="block w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('user_id') border-red-500 @enderror"
                            >
                                <option value="">Seleccione un inquilino</option>
                                @foreach($this->tenants as $tenant)
                                    <option value="{{ $tenant->id }}">
                                        {{ $tenant->name }} - {{ $tenant->email }} - ({{ $tenant->status->label() }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Renta Mensual y Día de Corte --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="monthly_rent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Renta Mensual <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">$</span>
                                    </div>
                                    <input
                                        type="text"
                                        id="monthly_rent"
                                        wire:model="monthly_rent"
                                        placeholder="500000"
                                        class="block w-full pl-7 pr-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('monthly_rent') border-red-500 @enderror"
                                    >
                                </div>
                                @error('monthly_rent')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Fecha de Inicio <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="start_date"
                                    wire:model="start_date"
                                    class="block w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('start_date') border-red-500 @enderror"
                                >
                                @error('start_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        {{-- Notas --}}
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notas
                            </label>
                            <textarea
                                id="notes"
                                wire:model="notes"
                                rows="3"
                                placeholder="Notas adicionales sobre el contrato..."
                                class="block w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow resize-none @error('notes') border-red-500 @enderror"
                            ></textarea>
                            @error('notes')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                        <button
                            type="button"
                            wire:click="close"
                            class="inline-flex justify-center items-center px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        >
                            Cancelar
                        </button>
                        <button
                            type="button"
                            wire:click="save"
                            class="inline-flex justify-center items-center px-4 py-2 rounded-lg bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Crear Contrato
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
