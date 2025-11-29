<div>
    @if($show && $lease)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-80" aria-hidden="true" wire:click="close"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detalles del Contrato</h3>
                            <button wire:click="close" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-6 py-4 space-y-4 max-h-[calc(100vh-16rem)] overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Apartamento</p><p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $lease->apartment->name }}</p></div>
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Inquilino</p><p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $lease->user->name }}</p></div>
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Renta Mensual</p><p class="text-sm font-bold text-gray-900 dark:text-white">{{ $lease->formatted_monthly_rent }}</p></div>
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Día de Corte</p><p class="text-sm text-gray-900 dark:text-white">Día {{ $lease->cutoff_day }}</p></div>
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Fecha de Inicio</p><p class="text-sm text-gray-900 dark:text-white">{{ $lease->start_date->format('d/m/Y') }}</p></div>
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Fecha de Fin</p><p class="text-sm text-gray-900 dark:text-white">{{ $lease->end_date ? $lease->end_date->format('d/m/Y') : 'Indefinido' }}</p></div>
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Estado</p><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium uppercase tracking-wide {{ $lease->status_badge_class }}">{{ $lease->status_text }}</span></div>
                            <div><p class="text-xs text-gray-500 dark:text-gray-400">Duración</p><p class="text-sm text-gray-900 dark:text-white">{{ $lease->getDurationInDays() }} días</p></div>
                        </div>
                        @if($lease->notes)<div><p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Notas</p><p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $lease->notes }}</p></div>@endif
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
                        <button wire:click="close" class="inline-flex justify-center items-center px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">Cerrar</button>
                        @if($lease->isActive())
                        <button wire:click="terminateLease" class="inline-flex justify-center items-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-colors">Terminar Contrato</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
