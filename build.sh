# Crear build.sh
echo "#!/bin/bash
composer install --optimize-autoloader --no-dev
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache" > build.sh