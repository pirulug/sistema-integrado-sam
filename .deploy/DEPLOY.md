```sh
# 1. Dependencias PHP con Composer
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --ignore-platform-req=php

# 2. Compilar assets de frontend con PNPM
if [ -f package.json ]; then
    pnpm approve-builds --all 2>/dev/null || true
    pnpm install
    pnpm rebuild 2>/dev/null || true
    pnpm run build
fi

# 3. Base de datos: Migraciones y Seeders
php artisan migrate:fresh --force
php artisan db:seed --class="AdminUserSeeder" --force
php artisan db:seed --class="CurseSeeder" --force
php artisan db:seed --class="EfsrtSeeder" --force

# 4. Enlace simbolico y optimizacion de Laravel
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```