# Componente de Tarjeta de Apartamento

## Descripción
Este componente crea una tarjeta clickeable para mostrar información de apartamentos en tu plataforma de gestión inmobiliaria.

## Características
- ✅ Diseño responsive y moderno
- ✅ Soporte para modo oscuro
- ✅ Efectos hover elegantes
- ✅ Indicador de estado (Arrendado/Disponible)
- ✅ Formato de precio automático
- ✅ Abre en nueva pestaña al hacer clic

## Uso Básico

```blade
<x-apartment-card 
    name="Nombre del Apartamento"
    address="Dirección del apartamento"
    :price="750000"
    :isRented="false"
    href="/apartments/1"
/>
```

## Parámetros

| Parámetro | Tipo | Requerido | Descripción | Valor por defecto |
|-----------|------|-----------|-------------|-------------------|
| `name` | string | No | Nombre del apartamento | "Apartamento Ejemplo" |
| `address` | string | No | Dirección completa | "Calle Ejemplo 123, Ciudad" |
| `price` | integer | No | Precio de arriendo mensual | 500000 |
| `isRented` | boolean | No | Estado de arriendo | false |
| `href` | string | No | URL de destino | "#" |

## Ejemplos de Uso

### Apartamento Disponible
```blade
<x-apartment-card 
    name="Loft Bellavista"
    address="Pío Nono 234, Bellavista, Santiago"
    :price="850000"
    :isRented="false"
    href="/apartments/4"
/>
```

### Apartamento Arrendado
```blade
<x-apartment-card 
    name="Departamento Las Condes"
    address="Av. Apoquindo 5678, Las Condes, Santiago"
    :price="1200000"
    :isRented="true"
    href="/apartments/2"
/>
```

## Vista de Ejemplo
Para ver el componente en acción, visita la ruta `/apartments` después de autenticarte.

## Personalización
El componente usa Tailwind CSS y puede ser personalizado modificando las clases en el archivo `resources/views/components/apartment-card.blade.php`.

### Colores de Estado
- **Disponible**: Verde (`bg-green-100 text-green-800`)
- **Arrendado**: Rojo (`bg-red-100 text-red-800`)

### Efectos Hover
- Sombra aumentada
- Color del título cambia a azul
- Aparece icono de flecha externa
- Overlay sutil de color azul

## Estructura de Archivos
```
resources/views/
├── components/
│   └── apartment-card.blade.php    # Componente principal
└── apartments/
    └── index.blade.php             # Vista de ejemplo
``` 