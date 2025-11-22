<div class="flex-1 self-stretch max-md:pt-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-zinc-900">Registro de Auditoría</h1>
            <p class="text-zinc-500 mt-1">Historial de cambios en el sistema</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-zinc-200 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-zinc-100">
                        <svg class="w-5 h-5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Total</p>
                        <p class="text-lg font-bold text-zinc-900">{{ number_format($this->stats['total']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-zinc-200 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Hoy</p>
                        <p class="text-lg font-bold text-zinc-900">{{ number_format($this->stats['today']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-zinc-200 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-50">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Creados</p>
                        <p class="text-lg font-bold text-zinc-900">{{ number_format($this->stats['created']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-zinc-200 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Actualizados</p>
                        <p class="text-lg font-bold text-zinc-900">{{ number_format($this->stats['updated']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-zinc-200 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-50">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Eliminados</p>
                        <p class="text-lg font-bold text-zinc-900">{{ number_format($this->stats['deleted']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-zinc-100">
                <h2 class="text-base font-semibold text-zinc-900">Filtros</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="md:col-span-2">
                        <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar..." icon="magnifying-glass"/>
                    </div>

                    <flux:select wire:model.live="model">
                        <option value="">Todos los modelos</option>
                        @foreach($this->availableModels as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model.live="event">
                        <option value="">Todos los eventos</option>
                        @foreach($this->availableEvents as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model.live="userId">
                        <option value="">Todos los usuarios</option>
                        @foreach($this->users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </flux:select>

                    <div class="flex items-end">
                        <flux:button wire:click="resetFilters" variant="ghost" class="w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Limpiar
                        </flux:button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mt-4">
                    <flux:input wire:model.live="dateFrom" type="date" label="Desde"/>
                    <flux:input wire:model.live="dateTo" type="date" label="Hasta"/>
                </div>
            </div>
        </div>

        {{-- Audit Logs Table --}}
        <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
                <h2 class="text-base font-semibold text-zinc-900">Registros</h2>
                <span class="text-sm text-zinc-500">{{ $this->logs->total() }} registros encontrados</span>
            </div>

            @if($this->logs->count() > 0)
                <div class="divide-y divide-zinc-100">
                    @foreach($this->logs as $log)
                        <div wire:click="showDetail({{ $log->id }})"
                             class="px-6 py-4 hover:bg-zinc-50 transition-colors cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    {{-- Event Badge --}}
                                    <div @class([
                                        'flex items-center justify-center w-10 h-10 rounded-lg',
                                        'bg-emerald-100' => $log->event === 'created',
                                        'bg-blue-100' => $log->event === 'updated',
                                        'bg-red-100' => $log->event === 'deleted',
                                    ])>
                                        @if($log->event === 'created')
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                        @elseif($log->event === 'updated')
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-zinc-900">{{ $log->model_name }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                                @if($log->event === 'created') bg-emerald-100 text-emerald-700
                                                @elseif($log->event === 'updated') bg-blue-100 text-blue-700
                                                @else bg-red-100 text-red-700
                                                @endif">
                                                {{ $log->event_label }}
                                            </span>
                                            <span class="text-xs text-zinc-400">#{{ $log->auditable_id }}</span>
                                        </div>
                                        <p class="text-sm text-zinc-500 mt-0.5">
                                            {{ $log->created_at->format('d M Y, H:i') }}
                                            @if($log->user)
                                                <span class="mx-1">·</span>
                                                <span class="text-zinc-600">{{ $log->user->name }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($log->event === 'updated' && count($log->changed_fields) > 0)
                                        <span class="text-xs text-zinc-500">
                                            {{ count($log->changed_fields) }} campo(s) modificado(s)
                                        </span>
                                    @endif
                                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-zinc-100">
                    {{ $this->logs->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-100 mb-4">
                        <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-zinc-900 mb-1">Sin registros</h3>
                    <p class="text-sm text-zinc-500">No se encontraron registros de auditoría con los filtros aplicados</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Detail Modal --}}
    @if($this->selectedLog)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data x-init="document.body.classList.add('overflow-hidden')" x-on:remove="document.body.classList.remove('overflow-hidden')">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-zinc-500/75" wire:click="closeDetail"></div>

                <div class="relative inline-block w-full max-w-3xl overflow-hidden text-left align-middle transition-all transform bg-white rounded-xl shadow-xl">
                    {{-- Modal Header --}}
                    <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div @class([
                                'flex items-center justify-center w-10 h-10 rounded-lg',
                                'bg-emerald-100' => $this->selectedLog->event === 'created',
                                'bg-blue-100' => $this->selectedLog->event === 'updated',
                                'bg-red-100' => $this->selectedLog->event === 'deleted',
                            ])>
                                @if($this->selectedLog->event === 'created')
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                @elseif($this->selectedLog->event === 'updated')
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-zinc-900">
                                    {{ $this->selectedLog->model_name }} {{ $this->selectedLog->event_label }}
                                </h3>
                                <p class="text-sm text-zinc-500">
                                    {{ $this->selectedLog->created_at->format('d M Y, H:i:s') }}
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeDetail" class="p-2 text-zinc-400 hover:text-zinc-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                        {{-- Metadata --}}
                        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-zinc-50 rounded-lg">
                            <div>
                                <p class="text-xs font-medium text-zinc-500 uppercase">Usuario</p>
                                <p class="text-sm text-zinc-900">{{ $this->selectedLog->user?->name ?? 'Sistema' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-zinc-500 uppercase">ID del Registro</p>
                                <p class="text-sm text-zinc-900">#{{ $this->selectedLog->auditable_id }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-zinc-500 uppercase">Dirección IP</p>
                                <p class="text-sm text-zinc-900">{{ $this->selectedLog->ip_address ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-zinc-500 uppercase">Navegador</p>
                                <p class="text-sm text-zinc-900 truncate" title="{{ $this->selectedLog->user_agent }}">
                                    {{ Str::limit($this->selectedLog->user_agent, 40) ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        {{-- Changes --}}
                        @if($this->selectedLog->event === 'updated')
                            <h4 class="text-sm font-semibold text-zinc-900 mb-3">Cambios Realizados</h4>
                            <div class="space-y-3">
                                @foreach($this->selectedLog->changed_fields as $field)
                                    <div class="border border-zinc-200 rounded-lg overflow-hidden">
                                        <div class="px-4 py-2 bg-zinc-50 border-b border-zinc-200">
                                            <span class="text-sm font-medium text-zinc-700">{{ $this->translateField($field) }}</span>
                                        </div>
                                        <div class="grid grid-cols-2 divide-x divide-zinc-200">
                                            <div class="p-3">
                                                <p class="text-xs font-medium text-red-600 mb-1">Antes</p>
                                                <p class="text-sm text-zinc-700 break-words">
                                                    @php
                                                        $oldValue = $this->selectedLog->old_values[$field] ?? null;
                                                    @endphp
                                                    @if(is_array($oldValue))
                                                        {{ implode(', ', $oldValue) ?: '(vacío)' }}
                                                    @elseif(is_bool($oldValue))
                                                        {{ $oldValue ? 'Sí' : 'No' }}
                                                    @else
                                                        {{ $oldValue ?? '(vacío)' }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="p-3">
                                                <p class="text-xs font-medium text-emerald-600 mb-1">Después</p>
                                                <p class="text-sm text-zinc-700 break-words">
                                                    @php
                                                        $newValue = $this->selectedLog->new_values[$field] ?? null;
                                                    @endphp
                                                    @if(is_array($newValue))
                                                        {{ implode(', ', $newValue) ?: '(vacío)' }}
                                                    @elseif(is_bool($newValue))
                                                        {{ $newValue ? 'Sí' : 'No' }}
                                                    @else
                                                        {{ $newValue ?? '(vacío)' }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($this->selectedLog->event === 'created')
                            <h4 class="text-sm font-semibold text-zinc-900 mb-3">Valores Iniciales</h4>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($this->selectedLog->new_values ?? [] as $field => $value)
                                    <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                                        <p class="text-xs font-medium text-emerald-700 mb-1">{{ $this->translateField($field) }}</p>
                                        <p class="text-sm text-zinc-700 break-words">
                                            @if(is_array($value))
                                                {{ implode(', ', $value) ?: '(vacío)' }}
                                            @elseif(is_bool($value))
                                                {{ $value ? 'Sí' : 'No' }}
                                            @else
                                                {{ $value ?? '(vacío)' }}
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <h4 class="text-sm font-semibold text-zinc-900 mb-3">Valores al Momento de Eliminación</h4>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($this->selectedLog->old_values ?? [] as $field => $value)
                                    <div class="p-3 bg-red-50 rounded-lg border border-red-100">
                                        <p class="text-xs font-medium text-red-700 mb-1">{{ $this->translateField($field) }}</p>
                                        <p class="text-sm text-zinc-700 break-words">
                                            @if(is_array($value))
                                                {{ implode(', ', $value) ?: '(vacío)' }}
                                            @elseif(is_bool($value))
                                                {{ $value ? 'Sí' : 'No' }}
                                            @else
                                                {{ $value ?? '(vacío)' }}
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Modal Footer --}}
                    <div class="px-6 py-4 border-t border-zinc-100 flex justify-end">
                        <flux:button wire:click="closeDetail" variant="ghost">
                            Cerrar
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
