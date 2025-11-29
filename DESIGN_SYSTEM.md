# Sistema de Diseño - Orion App

## 📐 Estándares de UI/UX

### Contenedor Principal
**IMPORTANTE:** Todos los componentes principales deben usar EXACTAMENTE esta estructura:

```blade
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div class="space-y-6">
        {{-- Contenido aquí --}}
    </div>
</div>
```

**Reglas:**
- ✅ Usar `py-6` para padding vertical consistente
- ✅ Usar `space-y-6` en el contenedor interno para espaciado automático entre secciones
- ❌ NO usar wrappers adicionales como `<div class="flex-1 self-stretch max-md:pt-6">`
- ❌ NO usar `mb-` en secciones principales (el `space-y-6` lo maneja automáticamente)
- ✅ Solo usar `mb-` en elementos internos pequeños (ej: `mb-1` entre label y valor)

### Tipografía

#### Títulos de Página (H1)
```blade
<h1 class="text-2xl font-bold text-gray-900 dark:text-white">Título</h1>
```

#### Subtítulos de Página
```blade
<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Descripción</p>
```

#### Títulos de Sección (H2)
```blade
<h2 class="text-lg font-semibold text-gray-900 dark:text-white">Sección</h2>
```

#### Headers de Tabla
```blade
<div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
    Columna
</div>
```

### Espaciado

#### Entre secciones principales
- `space-y-6` en el contenedor principal
- `mb-6` para separaciones específicas

#### Entre elementos de sección
- `mb-4` o `space-y-4`

#### Grid gaps
- Stats cards: `gap-4`
- Filtros: `gap-3`
- Formularios: `gap-4`

### Stats Cards

#### Estructura Base
```blade
<div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
    <div class="flex items-center justify-between">
        <div class="flex-1 min-w-0">
            <!-- Label -->
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                Label
            </p>
            <!-- Valor -->
            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                Valor
            </p>
        </div>
        <!-- Icon -->
        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400">...</svg>
        </div>
    </div>
    <!-- Gradient bottom border (opcional) -->
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-500"></div>
</div>
```

#### Grid de Stats
```blade
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stats cards -->
</div>
```

### Filtros y Búsqueda

#### Container
```blade
<div class="flex flex-col sm:flex-row gap-3">
    <!-- Filtros -->
</div>
```

#### Input de Búsqueda
```blade
<div class="flex-1 relative">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-4 w-4 text-gray-400">...</svg>
    </div>
    <input
        type="text"
        class="block w-full pl-9 pr-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
    >
</div>
```

### Tablas

#### Header
```blade
<div class="hidden sm:grid sm:grid-cols-12 gap-4 px-6 py-3 bg-gray-50 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
    <!-- Columnas -->
</div>
```

#### Rows Container
```blade
<div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800">
    <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
        <!-- Rows -->
    </div>
</div>
```

### Empty States

```blade
<div class="flex flex-col items-center justify-center py-16 px-4">
    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500">...</svg>
    </div>
    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Título</h3>
    <p class="text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">
        Descripción
    </p>
</div>
```

### Colores

#### Palette Principal
- Base: `gray-*` (NO usar `zinc-*`)
- Dark mode: `dark:bg-gray-800`, `dark:text-white`, `dark:border-gray-700`

#### Colores Semánticos
- Success: `emerald-*`
- Warning: `amber-*`
- Error: `red-*`
- Info: `blue-*`
- Primary: `violet-*`

### Shadows

- Cards: `shadow-sm`
- Modals: `shadow-xl`
- Dropdowns: `shadow-lg`

### Borders

- Cards: `border border-gray-200 dark:border-gray-700`
- Inputs: `border border-gray-200 dark:border-gray-700`
- Divisores: `divide-y divide-gray-100 dark:divide-gray-700/50`

### Border Radius

- Cards: `rounded-xl`
- Buttons: `rounded-lg`
- Badges: `rounded-full`
- Icons: `rounded-lg`

## 🎯 Checklist de Consistencia

Al crear o modificar un componente, verificar:

- [ ] Contenedor usa `mx-auto max-w-7xl px-4 sm:px-6 lg:px-8`
- [ ] Espaciado vertical usa `space-y-6`
- [ ] H1 usa `text-2xl font-bold`
- [ ] Subtítulos usan `text-sm text-gray-500 dark:text-gray-400`
- [ ] Stats cards tienen `text-2xl` para valores
- [ ] Grid de stats usa `gap-4`
- [ ] Cards tienen `shadow-sm`
- [ ] Colores usan `gray-*` (no `zinc-*`)
- [ ] Table headers usan `text-xs font-semibold uppercase tracking-wider`
- [ ] Border radius: cards `rounded-xl`, buttons `rounded-lg`
