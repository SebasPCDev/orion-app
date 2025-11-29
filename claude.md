# CLAUDE.MD - Guía de Desarrollo para IA

## 📋 INFORMACIÓN DEL PROYECTO

### Descripción General
**Orion App** es una aplicación de gestión inmobiliaria desarrollada en **Laravel 12** con **PHP 8.2+**. El sistema permite administrar apartamentos, inquilinos y pagos de arriendo con una interfaz moderna construida con **Livewire** y **Flux UI**. Incluye un sistema completo de auditoría para rastrear cambios en el sistema.

### Stack Tecnológico
- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Livewire, Flux UI, Alpine.js, Tailwind CSS 4.0
- **Base de Datos**: SQLite (por defecto), MySQL/PostgreSQL compatible
- **Herramientas**: Vite, PowerGrid (tablas), Laravel Pint (code style)
- **Notificaciones**: SweetAlert2
- **Testing**: PHPUnit, Laravel Testing

### Configuración Regional
- **Idioma**: Español (es)
- **Moneda**: COP (Pesos Colombianos)
- **Timezone**: UTC
- **Locale**: es_CO para formato de moneda

## 🏗️ ARQUITECTURA DEL PROYECTO

### Modelos Principales

#### 1. User (`app/Models/User.php`)
**Campos principales:**
- `identification_number` - Número de identificación único
- `name` - Nombre completo
- `phone`, `backup_phone` - Teléfonos de contacto
- `email` - Email único
- `role` - Rol del usuario (admin, tenant, owner)
- `status` - Estado como ENUM: 'active', 'inactive' (default: 'active')
- `payment_status` - Estado de pago manual: 'Al día', 'Retraso', 'Moroso'
- `cutoff_day` - Día de corte mensual para pagos (1-31)

**Relaciones:**
- `hasMany(Apartment)` - Múltiples apartamentos (propietarios)
- `hasOne(Apartment)` - Un apartamento asignado (inquilinos)
- `hasMany(Payment)` - Pagos realizados
- `morphMany(AuditLog)` - Logs de auditoría

**Traits:**
- `HasFactory`, `Notifiable`, `Auditable`

**Métodos especiales:**
- `initials()` - Iniciales del nombre
- `getCurrentCutoffDate()` - Fecha de corte actual basada en cutoff_day
- `getNextCutoffDate()` - Próxima fecha de corte
- `hasPaymentForCurrentPeriod()` - Verifica pago completo del período
- `getDaysSinceCutoff()` - Días transcurridos desde el corte
- `getPaymentStatusCalculatedAttribute()` - Estado calculado automáticamente:
  - `al_dia` - Tiene pago completo para período actual
  - `pendiente` - 0-10 días sin pago desde corte
  - `moroso` - Más de 10 días sin pago
- `getPaymentStatusLabelAttribute()` - Etiqueta en español del estado
- `getPaymentStatusColorAttribute()` - Color para badges (emerald, amber, red)
- `scopeTenants()` - Filtro para solo inquilinos

**Auditoría:**
```php
protected array $auditExclude = ['password', 'remember_token'];
```

#### 2. Apartment (`app/Models/Apartment.php`)
**Campos principales:**
- `user_id` - Inquilino asignado (FK nullable, único)
- `name` - Nombre/identificador del apartamento
- `address` - Dirección completa
- `price` - Precio de arriendo (integer)
- `is_rented` - Estado de arrendamiento (boolean)
- `block` - Bloque o edificio
- `description` - Descripción detallada
- `bedrooms`, `bathrooms` - Número de habitaciones y baños
- `area` - Área en m² (decimal 8,2)
- `floor`, `unit_number` - Piso y número de unidad
- `amenities` - Amenidades en JSON array
- `images` - URLs de imágenes en JSON array
- `status` - Estado: 'available', 'rented', 'maintenance'

**Relaciones:**
- `belongsTo(User)` - Inquilino asignado
- `hasMany(Payment)` - Pagos del apartamento
- `morphMany(AuditLog)` - Logs de auditoría

**Traits:**
- `HasFactory`, `Auditable`

**Métodos especiales:**
- `getFormattedPriceAttribute()` - Precio formateado en COP
- `getStatusBadgeClassAttribute()` - Clases CSS para badge de estado
- `getStatusTextAttribute()` - Texto del estado en español
- `scopeAvailable()` - Solo apartamentos disponibles
- `scopeRented()` - Solo apartamentos arrendados
- `scopeByBlock()` - Filtro por bloque

**Sincronización automática:**
- `is_rented` y `status` se sincronizan automáticamente

#### 3. Payment (`app/Models/Payment.php`)
**Campos principales:**
- `apartment_id` - Apartamento del pago (FK, cascade on delete)
- `user_id` - Usuario que realizó el pago (FK nullable, set null on delete)
- `amount` - Monto del pago (decimal 10,2)
- `payment_date` - Fecha del pago
- `month` - Mes en español (ENUM): 'Enero', 'Febrero', ..., 'Diciembre'
- `status` - Estado del pago (default: 'pending')
- `description` - Descripción o notas del pago

**Relaciones:**
- `belongsTo(Apartment)` - Apartamento del pago
- `belongsTo(User)` - Usuario que pagó
- `morphMany(AuditLog)` - Logs de auditoría

**Traits:**
- `HasFactory`, `Auditable`

#### 4. AuditLog (`app/Models/AuditLog.php`)
**Sistema de auditoría automática para rastrear cambios en el sistema.**

**Campos principales:**
- `auditable_type`, `auditable_id` - Relación polimórfica al modelo auditado
- `event` - Tipo de evento (ENUM): 'created', 'updated', 'deleted'
- `old_values` - Valores anteriores en JSON
- `new_values` - Valores nuevos en JSON
- `user_id` - Usuario que realizó la acción (FK nullable)
- `ip_address` - Dirección IP del usuario (varchar 45)
- `user_agent` - User agent del navegador

**Relaciones:**
- `morphTo('auditable')` - Relación polimórfica al modelo auditado
- `belongsTo(User)` - Usuario que realizó la acción

**Métodos especiales:**
- `getEventLabelAttribute()` - Etiqueta del evento en español
- `getEventColorAttribute()` - Color para badges (emerald, blue, red)
- `getModelNameAttribute()` - Nombre del modelo en español
- `getChangedFieldsAttribute()` - Lista de campos que cambiaron
- `scopeForModel($type)` - Filtrar por tipo de modelo
- `scopeByEvent($event)` - Filtrar por evento
- `scopeByUser($userId)` - Filtrar por usuario
- `scopeBetweenDates($from, $to)` - Filtrar por rango de fechas
- `scopeRecent($days = 30)` - Logs recientes

**Índices:**
- `['auditable_type', 'auditable_id']`
- `event`, `user_id`, `created_at`

### Traits Personalizados

#### Auditable (`app/Traits/Auditable.php`)
**Sistema completo de auditoría automática para modelos.**

**Funcionalidades:**
- Registra automáticamente eventos: created, updated, deleted
- Captura old_values y new_values en JSON
- Registra usuario autenticado, IP y user agent
- Excluye campos sensibles configurables por modelo
- Normaliza atributos automáticamente (casts, json, etc.)
- Puede deshabilitarse temporalmente

**Métodos principales:**
- `auditLogs()` - Relación polimórfica con AuditLog
- `withoutAuditing(Closure $callback)` - Ejecuta código sin auditar
- `logAudit($event, $oldValues, $newValues)` - Crea entrada de auditoría
- `getAuditableAttributes()` - Obtiene atributos a auditar
- `normalizeAttributesForAudit($attributes)` - Normaliza valores

**Configuración en modelos:**
```php
// Excluir campos específicos
protected array $auditExclude = ['password', 'remember_token'];

// Excluir timestamps (por defecto: true)
protected bool $auditExcludeTimestamps = true;
```

**Ejemplo de uso:**
```php
// Deshabilitar auditoría temporalmente
$user->withoutAuditing(function () use ($user) {
    $user->update(['some_field' => 'value']);
});
```

#### WithToastNotifications (`app/Traits/WithToastNotifications.php`)
**Sistema de notificaciones toast usando SweetAlert2.**

**Métodos disponibles:**
- `toastSuccess($title, $text = null)` - Notificación de éxito (5s, verde)
- `toastError($title, $text = null)` - Notificación de error (4s, roja)
- `toastWarning($title, $text = null)` - Notificación de advertencia (3.5s, naranja)
- `toastInfo($title, $text = null)` - Notificación informativa (3s, azul)
- `toastQuestion($title, $text = null)` - Notificación de pregunta (3s, azul claro)
- `toastCustom(array $options)` - Notificación personalizada

**Configuración automática:**
```php
'toast' => true,
'position' => 'top-end',
'showConfirmButton' => false,
'timer' => 3000-5000, // según tipo
'timerProgressBar' => true,
```

**Uso en componentes Livewire:**
```php
use WithToastNotifications;

public function save()
{
    // ...
    $this->toastSuccess('Guardado', 'El apartamento se guardó correctamente');
}
```

### Componentes Livewire Principales

#### ApartmentsComponent (`app/Livewire/ApartmentsComponent.php`)
**Gestión y listado de apartamentos con filtros avanzados.**

**Propiedades:**
- `search` - Búsqueda por nombre/dirección
- `blockFilter` - Filtro por bloque
- `statusFilter` - Filtro por estado

**Computed properties:**
- `apartments()` - Listado filtrado
- `apartmentsByBlock()` - Agrupados por bloque
- `blocks()` - Lista de bloques únicos
- `stats()` - Estadísticas (total, disponibles, arrendados, mantenimiento, ingreso mensual)

**Listeners:**
- `apartmentUpdated`, `apartmentCreated`, `apartmentDeleted`

#### EditApartmentComponent (`app/Livewire/EditApartmentComponent.php`)
**Edición completa de apartamentos.**

**Propiedades:**
- Todos los campos del apartamento (name, address, price, images, etc.)
- `tenant_id` - ID del inquilino asignado
- Campos de pago (amount, payment_date, payment_month, payment_description)

**Métodos:**
- `save()` - Actualiza apartamento (incluye images)
- `assignTenant()` - Asigna inquilino al apartamento
- `vacateApartment()` - Desocupa apartamento:
  - Actualiza inquilino a status 'inactive'
  - Desvincula de apartamento (user_id = null)
  - Marca apartamento como 'available'
- `hasPendingPayments()` - Verifica pagos pendientes

**Traits:** `WithToastNotifications`

**Layout:** `components.layouts.app`
**Título:** 'Editar Apartamento'

#### DashboardComponent (`app/Livewire/DashboardComponent.php`)
**Dashboard principal con métricas y gestión de pagos.**

**Propiedades de filtrado:**
- `search`, `monthFilter`, `apartmentFilter`, `statusFilter`
- `currentMonth`, `currentYear`

**Computed properties:**
- `metrics()` - Métricas anuales:
  - `totalRevenue` - Ingresos totales del año
  - `annualGoal` - Meta anual
  - `totalPayments` - Cantidad de pagos
  - `currentMonthPayments` - Pagos del mes actual
  - `rentedCount` - Apartamentos arrendados
  - `progressPercentage` - Progreso hacia la meta
- `payments()` - Pagos filtrados
- `apartments()` - Todos los apartamentos
- `rentedApartments()` - Solo apartamentos arrendados

**Métodos:**
- `deletePayment($paymentId)` - Elimina un pago
- `refreshData()` - Refresca datos (listener: 'paymentCreated')

**Traits:** `WithToastNotifications`

#### CreatePaymentModal (`app/Livewire/CreatePaymentModal.php`)
**Modal para crear pagos de arriendo.**

**Propiedades:**
- `apartment_id`, `tenant_name`, `amount`, `month`, `description`
- `rentedApartments`, `apartments`

**Métodos:**
- `getRemainingMonths()` - Meses restantes del año sin pago
- `updatedApartmentId()` - Al seleccionar apartamento:
  - Autocompleta tenant_name y amount
  - Verifica pagos duplicados del mes
- `updatedMonth()` - Actualiza descripción automáticamente
- `save()` - Crea pago:
  - Procesa formato de moneda (elimina puntos y comas)
  - Actualiza payment_status del usuario
  - Verifica duplicados

**Validaciones:**
- Verifica si ya existe pago para el mes seleccionado
- Valida campos requeridos

**Traits:** `WithToastNotifications`

#### TenantsComponent (`app/Livewire/TenantsComponent.php`)
**Gestión y listado de inquilinos.**

**Propiedades:**
- `search` - Búsqueda por nombre/email/teléfono
- `paymentStatusFilter` - Filtro por estado de pago

**Computed properties:**
- `tenants()` - Inquilinos filtrados (usa `payment_status_calculated`)
- `stats()` - Estadísticas:
  - `total` - Total de inquilinos
  - `alDia` - Inquilinos al día
  - `pendientes` - Inquilinos con pago pendiente
  - `morosos` - Inquilinos morosos
  - `sinAsignar` - Inquilinos sin apartamento

**Métodos:**
- `openCreateModal()` - Abre modal de crear inquilino
- `handleTenantCreated()` - Listener para refrescar tras crear
- `clearFilters()` - Limpia todos los filtros

**Traits:** `WithToastNotifications`

#### CreateTenantModal (`app/Livewire/CreateTenantModal.php`)
**Modal para crear nuevos inquilinos.**

**Propiedades:**
- `show` - Control de visibilidad del modal
- `name`, `email`, `phone`, `backup_phone`, `identification_number`
- `cutoff_day` - Día de corte mensual (1-31)
- `apartment_id` - Apartamento a asignar

**Validaciones:**
```php
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users,email',
'phone' => 'required|string|max:20',
'backup_phone' => 'nullable|string|max:20',
'identification_number' => 'required|string|max:50|unique:users',
'cutoff_day' => 'required|integer|min:1|max:31',
'apartment_id' => 'required|exists:apartments,id',
```

**Computed properties:**
- `availableApartments()` - Apartamentos disponibles para asignar

**Métodos:**
- `open()` - Abre modal (listener: 'open-create-tenant-modal')
- `save()` - Crea inquilino:
  - Genera password temporal automáticamente
  - Asigna apartamento seleccionado
  - Establece día de corte
  - Muestra password en notificación
- `close()` - Cierra modal y resetea campos

**Eventos despachados:**
- `tenant-created` - Tras crear inquilino exitosamente

**Traits:** `WithToastNotifications`

#### AuditLogPanel (`app/Livewire/AuditLogPanel.php`)
**Panel de auditoría con filtros avanzados.**

**Propiedades (sincronizadas con URL):**
- `search` - Búsqueda general
- `model` - Filtro por tipo de modelo
- `event` - Filtro por evento (created, updated, deleted)
- `userId` - Filtro por usuario
- `dateFrom`, `dateTo` - Rango de fechas
- `selectedLogId` - Log seleccionado para detalle

**Computed properties:**
- `availableModels()` - Modelos disponibles para filtrar
- `availableEvents()` - Eventos disponibles
- `users()` - Usuarios para dropdown
- `logs()` - Logs paginados (20 por página)
- `selectedLog()` - Log seleccionado para modal de detalle
- `stats()` - Estadísticas:
  - `total` - Total de registros
  - `today` - Registros de hoy
  - `created`, `updated`, `deleted` - Por tipo de evento

**Métodos:**
- `resetFilters()` - Resetea todos los filtros
- `showDetail($logId)` - Muestra modal con detalle del log
- `closeDetail()` - Cierra modal de detalle
- `translateField($field)` - Traduce nombres de campos al español

**Traits:** `WithPagination`

**Layout:** `components.layouts.app`
**Título:** 'Registro de Auditoría'

#### ToastManager (`app/Livewire/ToastManager.php`)
**Gestor global de notificaciones toast.**

**Listeners globales:**
- `toast-success` → `handleToastSuccess()`
- `toast-error` → `handleToastError()`
- `toast-warning` → `handleToastWarning()`
- `toast-info` → `handleToastInfo()`
- `toast-question` → `handleToastQuestion()`
- `toast-custom` → `handleToastCustom()`

**Traits:** `WithToastNotifications`

**Uso:**
```php
// Desde cualquier parte de la aplicación
$this->dispatch('toast-success', title: 'Éxito', text: 'Operación completada');
```

#### Componentes de Settings
- **Profile** (`app/Livewire/Settings/Profile.php`) - Gestión de perfil
- **Password** (`app/Livewire/Settings/Password.php`) - Cambio de contraseña
- **Appearance** (`app/Livewire/Settings/Appearance.php`) - Tema y apariencia
- **DeleteUserForm** (`app/Livewire/Settings/DeleteUserForm.php`) - Eliminación de cuenta

### Rutas Principales

```php
// Ruta pública
Route::view('/', 'welcome')->name('home');

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Apartamentos
    Route::view('apartments', 'apartments')->name('apartments.index');
    Route::get('apartments/{id}/edit', EditApartmentComponent::class)
        ->name('apartments.edit');

    // Pagos
    Route::get('pagos', function () {
        return view('livewire.payments-page');
    })->name('payments.index');

    // Inquilinos
    Route::view('tenants', 'livewire.tenants-page')->name('tenants');

    // Auditoría
    Route::get('audit-logs', AuditLogPanel::class)->name('audit-logs');

    // Configuraciones
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
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
├── Helpers/
│   ├── helpers.php              # Funciones auxiliares (meses en español)
│   └── ToastHelper.php          # Helpers de notificaciones toast
├── Http/Controllers/            # Controladores HTTP
├── Livewire/                   # Componentes Livewire
│   ├── Auth/                   # Autenticación
│   ├── Settings/               # Configuraciones
│   ├── ApartmentsComponent.php
│   ├── EditApartmentComponent.php
│   ├── DashboardComponent.php
│   ├── CreatePaymentModal.php
│   ├── TenantsComponent.php
│   ├── CreateTenantModal.php
│   ├── AuditLogPanel.php
│   └── ToastManager.php
├── Models/                     # Modelos Eloquent
│   ├── User.php
│   ├── Apartment.php
│   ├── Payment.php
│   └── AuditLog.php
├── Services/                   # Servicios
│   └── NotificationService.php # Servicio de notificaciones
├── Traits/                     # Traits personalizados
│   ├── Auditable.php           # Sistema de auditoría
│   └── WithToastNotifications.php  # Notificaciones toast
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
│   ├── *_create_audit_logs_table.php
│   ├── *_add_cutoff_day_to_users_table.php
│   ├── *_change_users_status_to_enum.php
│   └── *_add_images_to_apartments_table.php
├── factories/                 # Factories para testing
└── seeders/                   # Seeders de datos
```

### Archivos de Configuración
- `config/app.php` - Configuración principal (idioma: es, moneda: COP)
- `config/database.php` - Configuración de BD (SQLite/MySQL/PostgreSQL)
- `composer.json` - Dependencias PHP y scripts personalizados
- `package.json` - Dependencias Node.js
- `vite.config.js` - Configuración de Vite

## 🎨 CONVENCIONES DE CÓDIGO

### Estilo de Código
- **Laravel Pint** para formateo automático (PSR-12)
- Nombres en español para campos de usuario (name, description, etc.)
- Nombres en inglés para campos técnicos (created_at, updated_at, etc.)

### Convenciones de Nombres
- **Modelos**: PascalCase (User, Apartment, Payment, AuditLog)
- **Componentes Livewire**: PascalCase + "Component" (ApartmentsComponent)
- **Métodos**: camelCase (toggleRentStatus, deleteApartment, getCurrentCutoffDate)
- **Variables**: camelCase ($apartmentsByBlock, $monthlyIncome)
- **Rutas**: kebab-case (apartments.index, payments.index, audit-logs)

### Estructura de Componentes Livewire
```php
class ExampleComponent extends Component
{
    use WithToastNotifications;

    // Propiedades públicas
    public string $search = '';

    // Query string parameters
    protected $queryString = ['search' => ['except' => '']];

    // Computed properties
    public function items(): Collection
    {
        return Model::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->get();
    }

    // Método render
    public function render(): View
    {
        return view('livewire.example-component');
    }

    // Métodos de acción
    public function actionMethod(): void
    {
        // Lógica del método
        $this->toastSuccess('Éxito', 'Operación completada');
    }
}
```

## 🔧 FUNCIONES AUXILIARES Y SERVICIOS

### Helpers Disponibles (`app/Helpers/helpers.php`)
```php
// Conversión de meses inglés → español
monthToSpanish('January')      // 'Enero'
monthToSpanishShort('Jan')     // 'Ene'
```

### Helpers de Toast (`app/Helpers/ToastHelper.php`)
```php
toast_success('Título', 'Texto opcional')
toast_error('Título', 'Texto opcional')
toast_warning('Título', 'Texto opcional')
toast_info('Título', 'Texto opcional')
toast_question('Título', 'Texto opcional')
```

### NotificationService (`app/Services/NotificationService.php`)
**Servicio estático para notificaciones toast.**

```php
use App\Services\NotificationService;

// Métodos disponibles
NotificationService::success('Título', 'Texto');
NotificationService::error('Título', 'Texto');
NotificationService::warning('Título', 'Texto');
NotificationService::info('Título', 'Texto');
NotificationService::question('Título', 'Texto');
NotificationService::custom(['title' => '...', 'icon' => '...']);
```

### Métodos de Modelo Útiles

**User:**
```php
$user->initials()                         // Iniciales del nombre
$user->apartments()                       // Relación apartamentos
$user->payments()                         // Relación pagos
$user->getCurrentCutoffDate()             // Fecha de corte actual
$user->getNextCutoffDate()                // Próxima fecha de corte
$user->hasPaymentForCurrentPeriod()       // Tiene pago completo
$user->getDaysSinceCutoff()               // Días desde el corte
$user->payment_status_calculated          // Estado calculado automáticamente
$user->payment_status_label               // Etiqueta en español
$user->payment_status_color               // Color del badge
User::tenants()                           // Scope para solo inquilinos
```

**Apartment:**
```php
$apartment->formatted_price               // Precio formateado
$apartment->status_badge_class            // Clases CSS para estado
$apartment->status_text                   // Texto del estado en español
Apartment::available()                    // Scope solo disponibles
Apartment::rented()                       // Scope solo arrendados
Apartment::byBlock($block)                // Scope por bloque
```

**Payment:**
```php
$payment->apartment()                     // Relación apartamento
$payment->user()                          // Relación usuario
```

**AuditLog:**
```php
$log->event_label                         // Etiqueta del evento en español
$log->event_color                         // Color del badge
$log->model_name                          // Nombre del modelo en español
$log->changed_fields                      // Campos que cambiaron
AuditLog::forModel('App\Models\User')     // Scope por modelo
AuditLog::byEvent('created')              // Scope por evento
AuditLog::byUser($userId)                 // Scope por usuario
AuditLog::betweenDates($from, $to)        // Scope por rango de fechas
AuditLog::recent(30)                      // Scope logs recientes
```

## 🎯 PATRONES DE DESARROLLO

### Sistema de Auditoría
```php
// Aplicar auditoría a un modelo
class Example extends Model
{
    use Auditable;

    // Excluir campos sensibles (opcional)
    protected array $auditExclude = ['password', 'secret_key'];

    // Incluir timestamps en auditoría (opcional)
    protected bool $auditExcludeTimestamps = false;
}

// Deshabilitar auditoría temporalmente
$model->withoutAuditing(function () use ($model) {
    $model->update(['field' => 'value']);
});

// Consultar logs de auditoría
$user->auditLogs()->recent(7)->get();
AuditLog::forModel('App\Models\User')->byEvent('created')->get();
```

### Sistema de Corte de Pagos
```php
// Obtener estado de pago de un inquilino
$tenant = User::tenants()->find($id);
$status = $tenant->payment_status_calculated; // 'al_dia', 'pendiente', 'moroso'
$label = $tenant->payment_status_label;       // 'Al día', 'Pendiente', 'Moroso'
$color = $tenant->payment_status_color;       // 'emerald', 'amber', 'red'

// Verificar período de pago
$currentCutoff = $tenant->getCurrentCutoffDate();
$nextCutoff = $tenant->getNextCutoffDate();
$hasPaid = $tenant->hasPaymentForCurrentPeriod();
$daysSinceCutoff = $tenant->getDaysSinceCutoff();
```

### Notificaciones Toast
```php
// En componentes Livewire
use WithToastNotifications;

$this->toastSuccess('Éxito', 'Operación completada');
$this->toastError('Error', 'Algo salió mal');
$this->toastWarning('Advertencia', 'Revisa esto');

// Desde helpers globales
toast_success('Guardado', 'Los cambios se guardaron');
toast_error('Error', 'No se pudo guardar');

// Con servicio
NotificationService::success('Título', 'Mensaje');

// Toast personalizado
$this->toastCustom([
    'title' => 'Custom',
    'icon' => 'info',
    'timer' => 5000,
]);
```

### Filtros en Componentes Livewire
```php
public function items(): Collection
{
    return Model::query()
        ->when($this->search, function ($query) {
            $query->where('field', 'like', '%' . $this->search . '%');
        })
        ->when($this->filter, function ($query) {
            $query->where('status', $this->filter);
        })
        ->get();
}
```

### Manejo de Estados
```php
public function toggleStatus(Model $model): void
{
    $model->update(['status' => !$model->status]);
    $this->toastSuccess('Estado actualizado', 'El estado se cambió correctamente');
}
```

### Gestión de Apartamentos e Inquilinos
```php
// Asignar inquilino a apartamento
public function assignTenant(): void
{
    $this->validate(['tenant_id' => 'required|exists:users,id']);

    $this->apartment->update(['user_id' => $this->tenant_id, 'status' => 'rented']);
    $this->toastSuccess('Inquilino asignado');
}

// Desocupar apartamento
public function vacateApartment(): void
{
    if ($this->hasPendingPayments()) {
        $this->toastWarning('Advertencia', 'Hay pagos pendientes');
        return;
    }

    $tenant = $this->apartment->user;
    $tenant->update(['status' => 'inactive']);
    $this->apartment->update(['user_id' => null, 'status' => 'available']);

    $this->toastSuccess('Apartamento desocupado', "Se desvinculó a {$tenant->name}");
}
```

## 🚨 CONSIDERACIONES IMPORTANTES

### Seguridad
- Todas las rutas principales requieren autenticación (`auth` middleware)
- Validación de datos en componentes Livewire
- Protección CSRF habilitada por defecto
- Campos sensibles excluidos de auditoría

### Performance
- Uso de `when()` en queries para filtros condicionales
- Eager loading en relaciones cuando sea necesario
- Paginación en listados grandes (AuditLogPanel usa 20/página)
- Computed properties en Livewire para optimizar queries

### Internacionalización
- Aplicación configurada en español
- Meses en español en enum de payments
- Formato de moneda colombiana (COP)
- Helpers para conversión de fechas
- Traducción de campos en panel de auditoría

### Base de Datos
- SQLite por defecto para desarrollo
- Compatible con MySQL/PostgreSQL
- Migraciones con foreign keys y constraints
- Índices optimizados en audit_logs
- Soft deletes no implementado (usar con cuidado)

### Sistema de Auditoría
- Se registran automáticamente todos los cambios en User, Apartment, Payment
- Los timestamps se excluyen por defecto de la auditoría
- Los valores JSON se normalizan automáticamente
- Se captura IP y user agent para trazabilidad
- Los logs son solo lectura (no se editan ni eliminan desde UI)

### Sistema de Corte de Pagos
- El cálculo de payment_status_calculated es dinámico (no se almacena en BD)
- Estados:
  - **al_dia**: Pago completo para el período actual
  - **pendiente**: 0-10 días sin pago desde corte
  - **moroso**: Más de 10 días sin pago
- El cutoff_day debe estar entre 1 y 31
- Si el día de corte no existe en el mes, se usa el último día del mes

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
composer run test              # Alias para testing con config limpia
```

## 📝 DEPENDENCIAS Y CONFIGURACIÓN

### Dependencias Clave
```json
{
  "php": "^8.2",
  "laravel/framework": "^12.0",
  "livewire/flux": "^2.1.1",
  "livewire/volt": "^1.7.0",
  "power-components/livewire-powergrid": "*",
  "sweetalert2/laravel": "^1.0",
  "laravel/tinker": "^2.10.1"
}
```

### Dev Dependencies
```json
{
  "barryvdh/laravel-debugbar": "^3.16",
  "laravel/pint": "^1.18",
  "phpunit/phpunit": "^11.5.3"
}
```

### Autoload Files
```json
"files": [
  "app/Helpers/helpers.php",
  "app/Helpers/ToastHelper.php"
]
```

### Scripts Personalizados
```bash
composer run dev    # Servidor + queue + vite concurrentemente
composer run test   # Testing con configuración limpia
```

### Archivos de Configuración Especiales
- `.env.example` - Template de variables de entorno
- `vite.config.js` - Configuración de Vite con Tailwind CSS
- `composer.json` - Scripts personalizados para desarrollo

## 🔄 FLUJO DE TRABAJO RECOMENDADO

### Para Nuevas Funcionalidades
1. Crear migración si es necesario: `php artisan make:migration`
2. Actualizar modelos con relaciones y métodos
3. Aplicar trait `Auditable` si se requiere auditoría
4. Crear componente Livewire: `php artisan make:livewire ComponentName`
5. Crear vista Blade correspondiente
6. Agregar rutas en `routes/web.php`
7. Ejecutar tests: `composer run test`
8. Formatear código: `./vendor/bin/pint`

### Para Debugging
1. Usar Laravel Debugbar (habilitado en desarrollo)
2. Logs en `storage/logs/laravel.log`
3. `dd()` y `dump()` para debugging rápido
4. `php artisan tinker` para testing de modelos
5. Panel de auditoría para rastrear cambios

### Para Deployment
1. `composer install --optimize-autoloader --no-dev`
2. `npm run build`
3. `php artisan config:cache`
4. `php artisan route:cache`
5. `php artisan view:cache`
6. Configurar base de datos (MySQL/PostgreSQL en producción)

---

## 🎯 FUNCIONALIDADES PRINCIPALES DEL SISTEMA

### 1. Gestión de Apartamentos
- Crear, editar, listar apartamentos
- Filtrado por bloque, estado, búsqueda
- Estadísticas de disponibilidad e ingresos
- Gestión de imágenes
- Asignación de inquilinos
- Desocupación con validación de pagos

### 2. Gestión de Inquilinos
- Crear inquilinos con password temporal
- Asignación automática de apartamento
- Configuración de día de corte
- Cálculo automático de estado de pago
- Filtrado por estado de pago
- Estadísticas de inquilinos

### 3. Gestión de Pagos
- Registro de pagos mensuales
- Verificación de duplicados
- Actualización de estado de pago
- Dashboard con métricas anuales
- Filtrado por mes, apartamento, estado

### 4. Sistema de Auditoría
- Rastreo automático de cambios en User, Apartment, Payment
- Registro de creación, actualización y eliminación
- Captura de usuario, IP y user agent
- Filtros avanzados por modelo, evento, usuario, fecha
- Vista detallada de cambios campo por campo
- Estadísticas de actividad

### 5. Sistema de Corte de Pagos
- Día de corte configurable por inquilino (1-31)
- Cálculo automático de período de pago
- Estados dinámicos: al día, pendiente (0-10 días), moroso (>10 días)
- Verificación de pago completo para el período

### 6. Notificaciones
- Sistema toast con SweetAlert2
- Múltiples tipos: success, error, warning, info, question
- Timers personalizados con progress bar
- Uso desde componentes, helpers o servicio

---

**Última actualización**: Noviembre 2025
**Versión Laravel**: 12.x
**Versión PHP**: 8.2+
**Autor**: Sistema de Gestión Inmobiliaria Orion
