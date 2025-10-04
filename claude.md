# CLAUDE.MD - Guía de Desarrollo para IA

## 📋 INFORMACIÓN DEL PROYECTO

### Descripción General
**Orion App** es una aplicación de gestión inmobiliaria desarrollada en **Laravel 12** con **PHP 8.2+**. El sistema permite administrar apartamentos, inquilinos y pagos de arriendo con una interfaz moderna construida con **Livewire** y **Flux UI**.

### Stack Tecnológico
- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Livewire, Flux UI, Alpine.js, Tailwind CSS 4.0
- **Base de Datos**: SQLite (por defecto), MySQL compatible
- **Herramientas**: Vite, PowerGrid (tablas), Laravel Pint (code style)
- **Testing**: PHPUnit, Laravel Testing

### Configuración Regional
- **Idioma**: Español (es)
- **Moneda**: COP (Pesos Colombianos)
- **Timezone**: UTC
- **Locale**: es_CO para formato de moneda

## 🏗️ ARQUITECTURA DEL PROYECTO

### Modelos Principales
1. **User** (`app/Models/User.php`)
   - Campos: identification_number, name, phone, email, role, status, payment_status, backup_phone
   - Relaciones: hasMany(Apartment), hasMany(Payment)
   - Roles: admin, tenant, owner

2. **Apartment** (`app/Models/Apartment.php`)
   - Campos: name, address, price, is_rented, block, description, bedrooms, bathrooms, area, floor, unit_number, amenities, status
   - Relaciones: belongsTo(User), hasMany(Payment)
   - Estados: available, rented, maintenance

3. **Payment** (`app/Models/Payment.php`)
   - Campos: apartment_id, user_id, amount, payment_date, month, status, description
   - Relaciones: belongsTo(Apartment), belongsTo(User)
   - Meses: enum en español (Enero, Febrero, etc.)

### Componentes Livewire Principales
- **ApartmentsComponent**: Gestión y listado de apartamentos con filtros
- **PaymentsTable**: Tabla de pagos usando PowerGrid
- **EditApartmentComponent**: Edición de apartamentos
- **CreatePaymentModal**: Modal para crear pagos
- **DashboardMetrics**: Métricas del dashboard
- **TenantsTable**: Gestión de inquilinos

### Rutas Principales
```php
// Rutas autenticadas
Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('apartments', 'apartments')->name('apartments.index');
    Route::get('apartments/{id}/edit', EditApartmentComponent::class)->name('apartments.edit');
    Route::get('pagos', function () {
        return view('livewire.payments-page');
    })->name('payments.index');
    Route::view('tenants', 'livewire.tenants-page')->name('tenants');
    
    // Settings
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});
```

## 🛠️ COMANDOS Y SCRIPTS ÚTILES

### Comandos de Desarrollo
```bash
# Desarrollo completo (servidor + queue + vite)
composer run dev

# Solo servidor Laravel
php artisan serve

# Migraciones y seeders
php artisan migrate:fresh --seed

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Testing
composer run test
php artisan test

# Code Style (Laravel Pint)
./vendor/bin/pint
```

### Scripts NPM
```bash
npm run dev    # Desarrollo con Vite
npm run build  # Build para producción
```

## 📁 ESTRUCTURA DE ARCHIVOS CLAVE

### Directorios Importantes
```
app/
├── Helpers/helpers.php          # Funciones auxiliares (meses en español)
├── Http/Controllers/            # Controladores HTTP
├── Livewire/                   # Componentes Livewire
│   ├── Auth/                   # Autenticación
│   ├── Settings/               # Configuraciones
│   └── *.php                   # Componentes principales
├── Models/                     # Modelos Eloquent
└── Providers/                  # Service Providers

resources/
├── views/
│   ├── livewire/              # Vistas de componentes Livewire
│   ├── components/            # Componentes Blade
│   └── flux/                  # Componentes Flux UI
├── css/app.css                # Estilos principales
└── js/app.js                  # JavaScript principal

database/
├── migrations/                # Migraciones de BD
├── factories/                 # Factories para testing
└── seeders/                   # Seeders de datos
```

### Archivos de Configuración
- `config/app.php`: Configuración principal (idioma: es, moneda: COP)
- `config/database.php`: Configuración de BD (SQLite por defecto)
- `composer.json`: Dependencias PHP y scripts
- `package.json`: Dependencias Node.js
- `vite.config.js`: Configuración de Vite

## 🎨 CONVENCIONES DE CÓDIGO

### Estilo de Código
- **Laravel Pint** para formateo automático
- **PSR-12** como estándar base
- Nombres en español para campos de usuario (name, description, etc.)
- Nombres en inglés para campos técnicos (created_at, updated_at, etc.)

### Convenciones de Nombres
- **Modelos**: PascalCase (User, Apartment, Payment)
- **Componentes Livewire**: PascalCase + "Component" (ApartmentsComponent)
- **Métodos**: camelCase (toggleRentStatus, deleteApartment)
- **Variables**: camelCase ($apartmentsByBlock, $monthlyIncome)
- **Rutas**: kebab-case (apartments.index, payments.index)

### Estructura de Componentes Livewire
```php
class ExampleComponent extends Component
{
    // Propiedades públicas
    public string $search = '';
    
    // Query string parameters
    protected $queryString = ['search' => ['except' => '']];
    
    // Método render
    public function render(): View
    {
        return view('livewire.example-component');
    }
    
    // Métodos de acción
    public function actionMethod(): void
    {
        // Lógica del método
        session()->flash('message', 'Mensaje de éxito');
    }
}
```

## 🔧 FUNCIONES AUXILIARES

### Helpers Disponibles (`app/Helpers/helpers.php`)
```php
// Conversión de meses inglés -> español
monthToSpanish('January') // 'Enero'
monthToSpanishShort('Jan') // 'Ene'
```

### Métodos de Modelo Útiles
```php
// User
$user->initials() // Iniciales del nombre
$user->apartments() // Relación apartamentos
$user->payments() // Relación pagos

// Apartment
$apartment->getFormattedPriceAttribute() // Precio formateado
$apartment->getStatusBadgeClassAttribute() // Clases CSS para estado
$apartment->scopeAvailable() // Solo disponibles
$apartment->scopeRented() // Solo arrendados

// Payment
$payment->apartment() // Relación apartamento
$payment->user() // Relación usuario
```

## 🎯 PATRONES DE DESARROLLO

### Filtros en Componentes Livewire
```php
public function render(): View
{
    $query = Model::query()
        ->when($this->search, function ($query) {
            $query->where('field', 'like', '%' . $this->search . '%');
        })
        ->when($this->filter, function ($query) {
            $query->where('status', $this->filter);
        });
        
    return view('livewire.component', ['items' => $query->get()]);
}
```

### Manejo de Estados
```php
public function toggleStatus(Model $model): void
{
    $model->update(['status' => !$model->status]);
    session()->flash('message', 'Estado actualizado correctamente.');
}
```

### PowerGrid para Tablas
```php
public function datasource(): Builder
{
    return Model::query()
        ->join('related_table', 'models.related_id', '=', 'related_table.id')
        ->select('models.*', 'related_table.name as related_name');
}

public function fields(): PowerGridFields
{
    return PowerGrid::fields()
        ->add('formatted_field', fn ($model) => format($model->field));
}
```

## 🚨 CONSIDERACIONES IMPORTANTES

### Seguridad
- Todas las rutas principales requieren autenticación (`auth` middleware)
- Validación de datos en componentes Livewire
- Protección CSRF habilitada por defecto

### Performance
- Uso de `when()` en queries para filtros condicionales
- Eager loading en relaciones cuando sea necesario
- Paginación en listados grandes

### Internacionalización
- Aplicación configurada en español
- Meses en español en enum de payments
- Formato de moneda colombiana (COP)
- Helpers para conversión de fechas

### Base de Datos
- SQLite por defecto para desarrollo
- Migraciones con foreign keys y constraints
- Seeders para datos de prueba
- Soft deletes no implementado (usar con cuidado)

## 🧪 TESTING

### Estructura de Tests
```
tests/
├── Feature/
│   ├── Auth/                  # Tests de autenticación
│   ├── Settings/              # Tests de configuraciones
│   └── DashboardTest.php      # Tests del dashboard
└── Unit/                      # Tests unitarios
```

### Comandos de Testing
```bash
php artisan test                # Ejecutar todos los tests
php artisan test --filter=Auth  # Tests específicos
composer run test              # Alias para testing
```

## 📝 NOTAS ADICIONALES

### Dependencias Clave
- **livewire/flux**: UI components modernos
- **power-components/livewire-powergrid**: Tablas avanzadas
- **barryvdh/laravel-debugbar**: Debug en desarrollo
- **laravel/pint**: Code formatting

### Archivos de Configuración Especiales
- `.env.example`: Template de variables de entorno
- `vite.config.js`: Configuración de Vite con Tailwind CSS
- `composer.json`: Scripts personalizados para desarrollo

### Comandos Personalizados
```bash
composer run dev    # Servidor + queue + vite concurrentemente
composer run test   # Testing con configuración limpia
```

## 🔄 FLUJO DE TRABAJO RECOMENDADO

### Para Nuevas Funcionalidades
1. Crear migración si es necesario: `php artisan make:migration`
2. Actualizar modelos con relaciones y métodos
3. Crear componente Livewire: `php artisan make:livewire ComponentName`
4. Crear vista Blade correspondiente
5. Agregar rutas en `routes/web.php`
6. Ejecutar tests: `composer run test`
7. Formatear código: `./vendor/bin/pint`

### Para Debugging
1. Usar Laravel Debugbar (habilitado en desarrollo)
2. Logs en `storage/logs/laravel.log`
3. `dd()` y `dump()` para debugging rápido
4. `php artisan tinker` para testing de modelos

### Para Deployment
1. `composer install --optimize-autoloader --no-dev`
2. `npm run build`
3. `php artisan config:cache`
4. `php artisan route:cache`
5. `php artisan view:cache`

---

**Última actualización**: Octubre 2025  
**Versión Laravel**: 12.x  
**Versión PHP**: 8.2+  
**Autor**: Sistema de Gestión Inmobiliaria Orion
