# Componente Apartment Card

## Descripción
El componente `apartment-card` es un componente Blade reutilizable que permite mostrar información de apartamentos de manera consistente y personalizable en toda la aplicación.

## Ubicación
- **Componente**: `resources/views/components/apartment-card.blade.php`
- **Ejemplos**: `resources/views/components/apartment-card-examples.blade.php`

## Parámetros

### Requeridos
- `apartment` (Apartment): Instancia del modelo Apartment que contiene la información a mostrar

### Opcionales
- `width` (string, default: 'w-80'): Clases de Tailwind CSS para el ancho del componente
- `height` (string, default: 'h-auto'): Clases de Tailwind CSS para la altura del componente
- `showActions` (boolean, default: true): Determina si se muestran los botones de acción (editar, eliminar, cambiar estado)

## Uso Básico

```blade
{{-- Uso más simple --}}
<x-apartment-card :apartment="$apartment" />

{{-- Con parámetros personalizados --}}
<x-apartment-card 
    :apartment="$apartment"
    width="w-96"
    height="h-64"
    :show-actions="false"
/>
```

## Ejemplos de Tamaños

### Cards Pequeñas
```blade
<x-apartment-card 
    :apartment="$apartment"
    width="w-64"
    height="h-48"
    :show-actions="false"
/>
```

### Cards Medianas
```blade
<x-apartment-card 
    :apartment="$apartment"
    width="w-80"
    height="h-auto"
    :show-actions="true"
/>
```

### Cards Grandes
```blade
<x-apartment-card 
    :apartment="$apartment"
    width="w-96"
    height="h-64"
    :show-actions="true"
/>
```

### Cards de Ancho Completo
```blade
<x-apartment-card 
    :apartment="$apartment"
    width="w-full"
    height="h-32"
    :show-actions="false"
/>
```

## Uso en Grids

### Grid Responsivo
```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($apartments as $apartment)
        <x-apartment-card 
            :apartment="$apartment"
            width="w-full"
            height="h-auto"
            :show-actions="true"
        />
    @endforeach
</div>
```

### Flexbox
```blade
<div class="flex flex-wrap gap-6">
    @foreach($apartments as $apartment)
        <x-apartment-card 
            :apartment="$apartment"
            width="w-80"
            height="h-auto"
            :show-actions="true"
        />
    @endforeach
</div>
```

## Información Mostrada

El componente muestra automáticamente:

1. **Nombre del apartamento**
2. **Estado** (Disponible/Arrendado) con badge colorizado
3. **Dirección** con ícono de ubicación
4. **Información adicional** (si está disponible):
   - Número de habitaciones
   - Número de baños
   - Área en m²
5. **Precio formateado** con moneda
6. **Acciones** (si `showActions` es true):
   - Botón para cambiar estado de arriendo
   - Botón para editar apartamento
   - Botón para eliminar apartamento

## Métodos Requeridos en el Componente Livewire

Para que las acciones funcionen correctamente, el componente Livewire que use este componente debe tener los siguientes métodos:

```php
public function toggleRentStatus(Apartment $apartment): void
{
    $apartment->update([
        'is_rented' => !$apartment->is_rented,
        'status' => !$apartment->is_rented ? 'rented' : 'available'
    ]);
    
    session()->flash('message', 'Estado del apartamento actualizado.');
}

public function editApartment(Apartment $apartment)
{
    return redirect()->route('apartments.edit', $apartment->id);
}

public function deleteApartment(Apartment $apartment): void
{
    $apartment->delete();
    session()->flash('message', 'Apartamento eliminado exitosamente.');
}
```

## Clases CSS Personalizables

### Anchos Comunes
- `w-64` (16rem / 256px)
- `w-72` (18rem / 288px)
- `w-80` (20rem / 320px)
- `w-96` (24rem / 384px)
- `w-full` (100%)

### Alturas Comunes
- `h-auto` (altura automática)
- `h-32` (8rem / 128px)
- `h-48` (12rem / 192px)
- `h-64` (16rem / 256px)
- `h-full` (100%)

## Características del Componente

### Responsive
- Se adapta automáticamente a diferentes tamaños de pantalla
- Los elementos internos se reorganizan según el espacio disponible

### Dark Mode
- Soporte completo para modo oscuro
- Colores que se adaptan automáticamente al tema

### Interactividad
- Efectos hover en toda la card
- Transiciones suaves en los cambios de estado
- Botones con estados hover y focus

### Accesibilidad
- Tooltips informativos en los botones de acción
- Confirmación antes de eliminar apartamentos
- Estructura semántica correcta

## Personalización Avanzada

Si necesitas personalizar aún más el componente, puedes:

1. **Modificar el archivo del componente** directamente en `resources/views/components/apartment-card.blade.php`
2. **Crear variantes** copiando el componente con un nombre diferente
3. **Usar slots** para contenido adicional (requiere modificar el componente)

## Integración con Livewire

El componente está diseñado para funcionar perfectamente con Livewire:
- Los métodos `wire:click` se ejecutan en el componente padre
- Las actualizaciones de estado se reflejan automáticamente
- Los mensajes flash se muestran correctamente

## Ejemplo Completo

```blade
{{-- En tu vista Livewire --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($apartments as $apartment)
        <x-apartment-card 
            :apartment="$apartment"
            width="w-full"
            height="h-auto"
            :show-actions="auth()->user()->can('manage-apartments')"
        />
    @endforeach
</div>
```

Este componente hace que la gestión de apartamentos sea más consistente y mantenible en toda la aplicación.
