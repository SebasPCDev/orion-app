@props([
    'apartment' => [],
    'showActions' => true
])

<a
    href="{{ route('apartments.edit', $apartment->id) }}"
    wire:navigate
    class="group block"
>
    <div class="flex items-center gap-4 px-4 py-3 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">

        {{-- Status Indicator --}}
        <div class="flex-shrink-0">
            <div @class([
                'w-2 h-2 rounded-full',
                'bg-emerald-500' => !$apartment->is_rented,
                'bg-amber-500' => $apartment->is_rented && $apartment->status !== 'maintenance',
                'bg-gray-400' => $apartment->status === 'maintenance',
            ])></div>
        </div>

        {{-- Apartment Name & Address --}}
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    {{ $apartment->name }}
                </h3>
                <span @class([
                    'inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide',
                    'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' => !$apartment->is_rented,
                    'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' => $apartment->is_rented && $apartment->status !== 'maintenance',
                    'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' => $apartment->status === 'maintenance',
                ])>
                    {{ $apartment->status_text }}
                </span>
            </div>
            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 truncate">
                {{ $apartment->address }}
            </p>
        </div>

        {{-- Tenant Info (if rented) --}}
        <div class="hidden md:block min-w-[180px]">
            @if($apartment->is_rented && $apartment->user)
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                        <span class="text-[10px] font-medium text-gray-600 dark:text-gray-300">
                            {{ $apartment->user->initials() }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400 truncate max-w-[120px]">
                        {{ $apartment->user->name }}
                    </span>
                </div>
            @else
                <span class="text-xs text-gray-400 dark:text-gray-500">Sin inquilino</span>
            @endif
        </div>

        {{-- Price --}}
        <div class="flex-shrink-0 text-right min-w-[180px]">
            <div class="text-sm font-bold text-gray-900 dark:text-white">
                {{ $apartment->formatted_price }}
            </div>
            <div class="text-[10px] text-gray-500 dark:text-gray-400">/mes</div>
        </div>

        {{-- Arrow indicator --}}
        <div class="flex-shrink-0 text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
    </div>
</a>
