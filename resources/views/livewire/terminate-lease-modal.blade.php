<div>
    @if($show && $lease)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-80" aria-hidden="true" wire:click="close"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Terminar Contrato</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">¿Estás seguro de terminar el contrato de <strong>{{ $lease->apartment->name }}</strong> con <strong>{{ $lease->user->name }}</strong>?</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Razón</label>
                            <div class="space-y-2">
                                <label class="flex items-center"><input type="radio" wire:model="reason" value="completed" class="mr-2"><span class="text-sm text-gray-700 dark:text-gray-300">Completado normalmente</span></label>
                                <label class="flex items-center"><input type="radio" wire:model="reason" value="terminated" class="mr-2"><span class="text-sm text-gray-700 dark:text-gray-300">Terminado anticipadamente</span></label>
                            </div>
                        </div>
                        <div>
                            <label for="terminate_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notas finales (opcional)</label>
                            <textarea id="terminate_notes" wire:model="notes" rows="3" placeholder="Razón de terminación..." class="block w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white resize-none"></textarea>
                        </div>
                        <div class="rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-3">
                            <p class="text-xs text-amber-800 dark:text-amber-200"><strong>Nota:</strong> El apartamento quedará disponible y el inquilino será marcado como inactivo.</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                        <button wire:click="close" class="inline-flex justify-center items-center px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">Cancelar</button>
                        <button wire:click="terminate" class="inline-flex justify-center items-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-colors">Confirmar Terminación</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
