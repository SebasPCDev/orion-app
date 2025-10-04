<x-layouts.app.sidebar :title="$title ?? null">
    @include('sweetalert2::index')
    <flux:main>
        {{ $slot }}
    </flux:main>
    
    {{-- Toast Manager Global --}}
    <livewire:toast-manager />
</x-layouts.app.sidebar>
