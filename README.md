# orion-v1

## Instalación y configuración local

1. **Clona el repositorio:**
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd orion-v1-app
   ```

2. **Instala las dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Instala las dependencias de Node.js (opcional para assets):**
   ```bash
   npm install && npm run dev
   ```

4. **Copia el archivo de entorno y configura tus variables:**
   ```bash
   cp .env.example .env
   ```
   Edita el archivo `.env` y configura la conexión a tu base de datos:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=orion_db
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

5. **Genera la clave de la aplicación:**
   ```bash
   php artisan key:generate
   ```

6. **Ejecuta las migraciones y seeders:**
   ```bash
   php artisan migrate --seed
   ```
   O si quieres reiniciar todo:
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Levanta el servidor de desarrollo:**
   ```bash
   composer run dev
   ```
   Esto iniciará el servidor de Laravel, el worker de colas y Vite para los assets en modo desarrollo.

---

## Reiniciar la base de datos y ejecutar seeders (Laravel)

Para reiniciar completamente la base de datos y poblarla con datos de prueba, sigue estos pasos desde la terminal:

1. **Borrar todas las tablas y migrar desde cero:**

   ```bash
   php artisan migrate:fresh
   ```
   Esto eliminará todas las tablas y ejecutará todas las migraciones desde el inicio.

2. **(Opcional) Ejecutar los seeders para poblar la base de datos:**

   ```bash
   php artisan db:seed
   ```
   O si quieres que se ejecute automáticamente después de migrar:
   ```bash
   php artisan migrate:fresh --seed
   ```

**Resumen del proceso:**
- `php artisan migrate:fresh` — Borra y recrea todas las tablas.
- `php artisan db:seed` — Llena la base con datos de prueba.

Esto es útil para entornos de desarrollo y pruebas.