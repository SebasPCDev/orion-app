<x-layouts.app :title="__('Listado de Inquilinos')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Listado de Inquilinos</h1>
        </div>
        
        <livewire:tenants-table />
    </div>
</x-layouts.app> 