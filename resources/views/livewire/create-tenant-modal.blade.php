<div>
    @if($show)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                {{-- Backdrop --}}
                <div class="fixed inset-0 transition-opacity bg-zinc-500/75" wire:click="close"></div>

                {{-- Modal --}}
                <div class="relative inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white rounded-xl shadow-xl">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-violet-100">
                                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-zinc-900">Nuevo Inquilino</h3>
                                <p class="text-sm text-zinc-500">Registrar un nuevo inquilino en el sistema</p>
                            </div>
                        </div>
                        <button wire:click="close" class="p-2 text-zinc-400 hover:text-zinc-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Body --}}
                    <form wire:submit="save" class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <flux:input
                                    wire:model="name"
                                    label="Nombre completo"
                                    placeholder="Nombre del inquilino"
                                    required
                                />
                            </div>

                            <flux:input
                                wire:model="identification_number"
                                label="Documento de identidad"
                                placeholder="Ej: 1234567890"
                                required
                            />

                            <flux:input
                                wire:model="email"
                                type="email"
                                label="Correo electrónico"
                                placeholder="correo@ejemplo.com"
                                required
                            />

                            <flux:input
                                wire:model="phone"
                                label="Teléfono principal"
                                placeholder="Ej: 3001234567"
                                required
                            />

                            <flux:input
                                wire:model="backup_phone"
                                label="Teléfono alternativo"
                                placeholder="Opcional"
                            />

                            <div class="md:col-span-2">
                                <flux:input
                                    wire:model="cutoff_day"
                                    type="number"
                                    min="1"
                                    max="31"
                                    label="Día de corte (fecha de pago mensual)"
                                    placeholder="Ej: 15"
                                    required
                                />
                                <p class="mt-1 text-xs text-zinc-500">
                                    El día del mes en que el inquilino debe realizar su pago. Se usará para calcular el estado de pago.
                                </p>
                            </div>
                        </div>

                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-amber-800">Nota importante</p>
                                    <p class="text-sm text-amber-700">
                                        Se generará una contraseña temporal automáticamente. Asegúrate de comunicarla al inquilino.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-100">
                            <flux:button type="button" wire:click="close" variant="ghost">
                                Cancelar
                            </flux:button>
                            <flux:button type="submit" variant="primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Registrar Inquilino
                            </flux:button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
