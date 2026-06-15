# SI SAM - Sistema Integral SAM

> [!WARNING]
> ### 🚨 PROHIBIDO PUSHEAR A MASTER 🚨
> Está **total y terminantemente prohibido** realizar commits o pushes directos a la rama `master`.
> Todos los cambios deben pasar obligatoriamente por Pull Request y validarse en la rama `develop` antes de integrarse. Para más detalles del flujo, consulte [GIT_WORKFLOW.md](file:///c:/Pirulug/Laravel/sistema-integrado-sam/GIT_WORKFLOW.md).

Este es el repositorio de SI SAM (Sistema Integral SAM). A continuación, se detallan las instrucciones paso a paso para desplegar el proyecto en un entorno de desarrollo local.

## Requisitos Previos

Antes de comenzar, asegúrese de tener instalado en su sistema:
* PHP (versión 8.2 o superior)
* Composer
* Node.js (con NPM)
* SQLite (o el motor de base de datos de su preferencia)

> [!TIP]
> **Recomendación para entorno local:** Para configurar PHP, Composer y servidores web de forma rápida y sencilla en Windows o macOS, recomendamos utilizar **Laravel Herd** (disponible en [herd.laravel.com](https://herd.laravel.com/)).

## Pasos para el Despliegue Local

### 1. Clonar o descargar el proyecto
Descargue los archivos del repositorio en su directorio de trabajo local.

### 2. Configurar las variables de entorno
Copie el archivo de ejemplo para crear su archivo de configuración local:
```bash
copy .env.example .env
```
*(Nota: En sistemas Linux/macOS use `cp .env.example .env`)*.

### 3. Instalar dependencias de PHP
Ejecute Composer para descargar e instalar todas las dependencias del framework:
```bash
composer install
```

### 4. Generar la clave de la aplicación
Genere la clave única de encriptación de Laravel:
```bash
php artisan key:generate
```

### 5. Configurar la base de datos
Por defecto, el proyecto está configurado para usar **SQLite** en desarrollo local. Debe crear un archivo de base de datos vacío en la ruta correspondiente:
```bash
# En Windows (PowerShell):
New-Item -Path "database" -Name "database.sqlite" -ItemType "file"

# En Windows (CMD) o Linux/macOS:
touch database/database.sqlite
```
Verifique en su archivo `.env` que la siguiente línea esté configurada:
```env
DB_CONNECTION=sqlite
```

> [!TIP]
> **Recomendación para producción o escalabilidad:** Si prefiere utilizar un motor de base de datos más robusto, recomendamos utilizar **MariaDB** o **MySQL**. Para ello, cree la base de datos en su gestor y configure las siguientes variables en su archivo `.env`:
> ```env
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=sistema_integrado_sam
> DB_USERNAME=su_usuario
> DB_PASSWORD=su_contraseña
> ```

### 6. Ejecutar migraciones y sembrar datos de prueba (Seeders)
Ejecute el siguiente comando para estructurar la base de datos e insertar los datos iniciales (incluyendo las 8 carreras por defecto, estudiantes y profesores de prueba):
```bash
php artisan migrate:fresh --seed
```

### 7. Instalar y compilar recursos frontend
Instale los paquetes de Node.js y compile los estilos y scripts con Vite:
```bash
# Instalar dependencias
npm install

# Compilar para producción (Recomendado para verificar el diseño)
npm run build

# O bien, ejecutar el servidor de desarrollo de Vite:
npm run dev
```

### 8. Iniciar el servidor local de Laravel
Inicie el servidor local de desarrollo de PHP:
```bash
php artisan serve
```
La aplicación estará disponible en la dirección [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## Credenciales de Acceso

* **Usuario:** `admin@example.com`
* **Contraseña:** `admin123`