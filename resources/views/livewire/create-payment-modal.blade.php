<div class="space-y-6">
    <form wire:submit.prevent="save">
        <div>
            <flux:heading size="lg">Ingresa un nuevo pago</flux:heading>
            <flux:text class="mt-2">Selecciona un apartamento para cargar los datos del inquilino.</flux:text>
            @error('existing-payment') <span class="text-orange-500 text-xs flex items-center gap-1"> <flux:icon.exclamation-triangle/> {{ $message }}</span> @enderror
        </div>

        <div class="space-y-4 mt-6">
            <flux:select label="Apartamento" wire:model.live="apartment_id">
                <flux:select.option value="" label="Seleccione un apartamento" />
                @if($apartments)
                    @foreach($apartments as $apartment)
                        <flux:select.option :value="$apartment->id" :label="$apartment->name" />
                    @endforeach
                @endif
            </flux:select>
            @error('apartment_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <flux:icon.loading wire:loading.flex wire:target="apartment_id" class="mx-auto" />

            @if($apartment_id)
                <flux:input icon="user" label="Inquilino" wire:model="tenant_name" readonly />
                <flux:input icon="currency-dollar" label="Valor" x-mask:dynamic="$money($input)" wire:model="amount" />

                <flux:select label="Mes a Pagar" wire:model.live="month">
                    @foreach($this->getRemainingMonths() as $monthValue => $monthLabel)
                        <flux:select.option :value="$monthValue" :label="$monthLabel" />
                    @endforeach
                </flux:select>

                <flux:textarea label="Descripción" wire:model="description" rows="3" />
            @endif
        </div> 
        @if($apartment_id)
            <div class="flex mt-6 gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Agregar Pago</flux:button>
            </div>
        @endif
    </form>
</div>

