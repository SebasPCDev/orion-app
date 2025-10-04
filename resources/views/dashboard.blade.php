<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <flux:modal.trigger name="create-payment-modal">
                <flux:button variant="primary" class="cursor-pointer">Nuevo Pago</flux:button>
            </flux:modal.trigger>
        </div>
        <livewire:dashboard-metrics />
        <livewire:payments-table />

    </div>



</x-layouts.app>




            