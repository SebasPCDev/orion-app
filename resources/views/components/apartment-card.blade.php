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

        {{-- Property Details --}}
        <div class="hidden sm:flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
            @if($apartment->bedrooms)
                <div class="flex items-center gap-1" title="Habitaciones">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>{{ $apartment->bedrooms }}</span>
                </div>
            @endif

            @if($apartment->bathrooms)
                <div class="flex items-center gap-1" title="Banos">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                    </svg>
                    <span>{{ $apartment->bathrooms }}</span>
                </div>
            @endif

            @if($apartment->area)
                <div class="flex items-center gap-1" title="Area">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                    <span>{{ $apartment->area }}m²</span>
                </div>
            @endif
        </div>

        {{-- Tenant Info (if rented) --}}
        <div class="hidden md:block min-w-[120px]">
            @if($apartment->is_rented && $apartment->user)
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                        <span class="text-[10px] font-medium text-gray-600 dark:text-gray-300">
                            {{ $apartment->user->initials() }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400 truncate max-w-[80px]">
                        {{ $apartment->user->name }}
                    </span>
                </div>
            @else
                <span class="text-xs text-gray-400 dark:text-gray-500">Sin inquilino</span>
            @endif
        </div>

        {{-- Price --}}
        <div class="flex-shrink-0 text-right min-w-[100px]">
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
