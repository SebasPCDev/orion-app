<div class="space-y-6">
    <form wire:submit.prevent="save">
        <div>
            <flux:heading size="lg">Nuevo Pago</flux:heading>
            <flux:text class="mt-2">Completa los detalles para registrar un nuevo pago.</flux:text>
        </div>

        <div class="space-y-4 mt-6">
            <flux:select label="Apartamento" wire:model.live="apartment_id" placeholder="Seleccione un apartamento">
                @if($apartments)
                    @foreach($apartments as $apartment)
                        <flux:select.option :value="$apartment->id" :label="$apartment->name" />
                    @endforeach
                @endif
            </flux:select>
            @error('apartment_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <flux:input label="Inquilino" wire:model="tenant_name" readonly />
            <flux:input label="Valor" wire:model="amount" type="number" />

            <flux:select label="Mes a Pagar" wire:model.live="month">
                @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $m)
                    <flux:select.option :value="$m" :label="$m" />
                @endforeach
            </flux:select>

            <flux:textarea label="Descripción" wire:model="description" rows="3" />
        </div>

        <div class="flex mt-6 gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancelar</flux:button>
            </flux:modal.close>
            <flux:button type="submit" variant="primary">Agregar Pago</flux:button>
        </div>
    </form>
</div>
