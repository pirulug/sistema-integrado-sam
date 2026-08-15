# Checklist de Avance Detallado - GUIDO (Líder - Full Stack)

Este documento contiene la hoja de ruta, especificaciones técnicas y el registro de desarrollo Full Stack para el programador GUIDO (Líder Técnico). Refleja las funcionalidades desarrolladas e integradas en el proyecto (Autenticación, Usuarios, Roles, Estudiantes, Docentes, Malla Curricular, Cursos, EFSRT, Motor de Graduación y Landing Page), así como las tareas de liderazgo técnico y optimización.

* Duración total asignada: 332 horas (13 semanas de 24 horas y Semana 14 de 20 horas)
* Fecha de inicio: 1 de Junio de 2026
* Cierre de proyecto: 04 de Setiembre de 2026
* Tecnologías: Laravel 12, PHP 8.x, MariaDB, Blade, Bootstrap 5, Vanilla JS, CSS Vanilla

---

## Semana 1: 01 de Junio al 06 de Junio
* Horas semanales: 24
* Horas acumuladas: 24
* Estado: Completado
* Entregables: Arquitectura Base, Esquema de Base de Datos Core, Modelos y Configuración Inicial de Autenticación.

### Tareas y Actividades
* [x] Configuración y estandarización del repositorio del proyecto:
  * [x] Establecer flujo de trabajo Git y reglas de ramas (main, develop, feature/*).
  * [x] Configurar variables de entorno iniciales en `.env.example` y conexión a MariaDB.
* [x] Diseño e implementación de migraciones de la base de datos core:
  * [x] Crear tabla `users` con roles y campos de autenticación -> [0001_01_01_000000_create_users_table.php](../database/migrations/0001_01_01_000000_create_users_table.php)
  * [x] Crear tabla `students` con datos personales, código, DNI y fechas académicas -> [2026_06_16_163213_create_students_table.php](../database/migrations/2026_06_16_163213_create_students_table.php)
  * [x] Crear tabla `teachers` con información de contacto y especialidad -> [2026_06_16_163637_create_teachers_table.php](../database/migrations/2026_06_16_163637_create_teachers_table.php)
* [x] Definición de Modelos Eloquent Core:
  * [x] Configurar modelo `User.php` con `$fillable`, `$hidden` y casts de contraseña.
  * [x] Configurar modelo `Student.php` con relaciones hacia cursos, planes y EFSRTs.
  * [x] Configurar modelo `Teacher.php` con atributos de contacto y asignaciones.
* [x] Configuración de Seeders y Datos de Prueba Iniciales:
  * [x] Crear `DatabaseSeeder.php` poblando usuarios con roles `admin` y `teacher`.
  * [x] Poblar registros iniciales de estudiantes y docentes de prueba.

---

## Semana 2: 08 de Junio al 13 de Junio
* Horas semanales: 24
* Horas acumuladas: 48
* Estado: Completado
* Entregables: Módulo de Autenticación, Gestión de Perfil de Usuario y Landing Page Institucional.

### Tareas y Actividades
* [x] Backend de Autenticación y Sesiones:
  * [x] Implementar `AuthenticatedSessionController.php` (login, logout, regeneración de sesión).
  * [x] Implementar `RegisteredUserController.php` con validación de credenciales.
  * [x] Implementar `ProfileController.php` para actualización de datos y contraseña.
  * [x] Configurar middleware de protección de rutas y restricción por rol (`role:teacher`, `role:admin`).
* [x] Frontend de Autenticación y Landing Page (Vistas Blade y UI):
  * [x] Crear vista de inicio de sesión (`resources/views/auth/login.blade.php`).
  * [x] Crear vista de registro (`resources/views/auth/register.blade.php`).
  * [x] Crear vista de edición de perfil (`resources/views/profile/edit.blade.php`).
  * [x] Desarrollar la Landing Page institucional completa (`resources/views/landing.blade.php`) con buscador público.

---

## Semana 3: 15 de Junio al 20 de Junio
* Horas semanales: 24
* Horas acumuladas: 72
* Estado: Completado
* Entregables: Módulo de Estudiantes y Docentes Full Stack (CRUD Completo y Vistas Blade).

### Tareas y Actividades
* [x] Módulo de Estudiantes Full Stack:
  * [x] Implementar `StudentController.php` (métodos `index`, `create`, `store`, `edit`, `update`, `destroy`).
  * [x] Crear vista de listado de estudiantes (`resources/views/students/index.blade.php`) con buscador y paginación.
  * [x] Crear formulario de registro de estudiantes (`resources/views/students/create.blade.php`).
  * [x] Crear formulario de edición de estudiantes (`resources/views/students/edit.blade.php`).
  * [x] Crear vista de ficha académica integral (`resources/views/students/show.blade.php`).
* [x] Módulo de Docentes Full Stack:
  * [x] Implementar `TeacherController.php` (CRUD completo).
  * [x] Crear vista de listado de docentes (`resources/views/teachers/index.blade.php`).
  * [x] Crear formularios de creación y edición (`resources/views/teachers/create.blade.php` y `edit.blade.php`).

---

## Semana 4: 22 de Junio al 27 de Junio
* Horas semanales: 24
* Horas acumuladas: 96
* Estado: Completado
* Entregables: Módulo de Planes de Estudio (Curriculums) y Cursos de Malla Curricular Full Stack.

### Tareas y Actividades
* [x] Módulo de Planes de Estudio (Curriculums) Full Stack:
  * [x] Crear migración `curriculums` -> [2026_06_16_163212_create_curriculums_table.php](../database/migrations/2026_06_16_163212_create_curriculums_table.php)
  * [x] Implementar modelo `Curriculum.php` y `CurriculumController.php`.
  * [x] Crear vistas Blade (`resources/views/curriculums/index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`).
* [x] Módulo de Cursos (Malla Curricular) Full Stack:
  * [x] Crear migración `courses` y tabla pivote `course_curriculum` -> [2026_06_16_163849_create_courses_table.php](../database/migrations/2026_06_16_163849_create_courses_table.php)
  * [x] Implementar modelo `Course.php` y `CourseController.php`.
  * [x] Crear vistas Blade para cursos (`resources/views/courses/index.blade.php`, `create.blade.php`, `edit.blade.php`).
  * [x] Implementar importación y carga automática de asignaturas por periodo (I al VI) desde CSV en `DatabaseSeeder.php`.

---

## Semana 5: 29 de Junio al 04 de Julio
* Horas semanales: 24
* Horas acumuladas: 120
* Estado: Completado
* Entregables: Módulo de EFSRT (Prácticas Formativas) y Seguimiento Académico Full Stack.

### Tareas y Actividades
* [x] Módulo de EFSRT Full Stack:
  * [x] Crear migración `efsrts` y tabla pivote `efsrt_student` -> [2026_06_16_164114_create_efsrts_table.php](../database/migrations/2026_06_16_164114_create_efsrts_table.php)
  * [x] Implementar modelo `Efsrt.php` con los 3 módulos formativos reglamentarios.
  * [x] Implementar `EfsrtController.php` (CRUD completo de módulos formativos).
  * [x] Crear vistas Blade (`resources/views/efsrts/index.blade.php`, `create.blade.php`, `edit.blade.php`).
* [x] Control de Prácticas por Alumno:
  * [x] Lógica de asignación de empresa, horas acumuladas, fechas de inicio/fin y estado de aprobación.
  * [x] Sincronización de módulos formativos asociados a cada plan de estudios.

---

## Semana 6: 06 de Julio al 11 de Julio
* Horas semanales: 24
* Horas acumuladas: 144
* Estado: Completado
* Entregables: Motor de Graduación, Verificación de Cursos/EFSRTs y Titulación Full Stack.

### Tareas y Actividades
* [x] Backend del Motor de Graduación:
  * [x] Implementar `GraduationController.php` con métodos clave:
    * [x] `index`: Vista del panel de verificación de requisitos con avance de créditos.
    * [x] `toggleCourse`: Marcado asíncrono e individual de asignaturas aprobadas.
    * [x] `bulkCourses`: Aprobación masiva de cursos por ciclo o plan completo.
    * [x] `updateEfsrt`: Validación y actualización de estado de prácticas formativas.
    * [x] `titular`: Emisión y registro formal de la condición de Titulado con fecha de grado.
    * [x] `publicLookup`: Endpoint y búsqueda pública de constancias de titulación.
* [x] Frontend del Panel de Graduación (Blade):
  * [x] Crear panel interactivo de graduación (`resources/views/graduation/index.blade.php`) con resumen visual.
  * [x] Crear vista pública de verificación de título (`resources/views/graduation/public_show.blade.php`).

---

## Semana 7: 13 de Julio al 18 de Julio
* Horas semanales: 24
* Horas acumuladas: 168
* Estado: En Progreso
* Entregables: Refactorización de Arquitectura, Optimización del Core y APIs Internas.

### Tareas y Actividades
* [x] Estandarización de Rutas y Controladores:
  * [x] Agrupar rutas en `routes/web.php` bajo middlewares de roles y autenticación.
* [ ] APIs REST Internas para Estudiantes y Graduación:
  * [ ] Crear recursos JSON (`StudentResource.php`, `GraduationResource.php`).
  * [ ] Implementar endpoints API para consumo dinámico desde componentes frontend.
* [ ] Coordinación Técnica:
  * [ ] Definir interfaces de integración para los módulos de César (Expedientes/Tesis) y Cirilo (Jurados/Sustentaciones).

---

## Semana 8: 20 de Julio al 25 de Julio
* Horas semanales: 24
* Horas acumuladas: 192
* Estado: Pendiente
* Entregables: Políticas de Seguridad Avanzadas (Laravel Policies) y Gateways de Autorización.

### Tareas y Actividades
* [ ] Políticas de Seguridad (Laravel Policies):
  * [ ] Implementar `StudentPolicy.php` para restringir operaciones de modificación de alumnos.
  * [ ] Implementar `CurriculumPolicy.php` y `GraduationPolicy.php`.
  * [ ] Registrar policies en `AuthServiceProvider.php`.
* [ ] Frontend con Control de Acceso Granular:
  * [ ] Integrar directivas `@can` en todas las vistas Blade del core para ocultar acciones no autorizadas.
  * [ ] Proteger visualmente las acciones de titulación y carga masiva únicamente para el rol administrador.

---

## Semana 9: 27 de Julio al 01 de Agosto
* Horas semanales: 24
* Horas acumuladas: 216
* Estado: Pendiente
* Entregables: Liderazgo Técnico - Revisión de Pull Requests e Integración de Módulos.

### Tareas y Actividades
* [ ] Revisión de Código y Pull Requests:
  * [ ] Revisar y aprobar PRs de César (Expedientes de Titulación, Tesis y Asesorías).
  * [ ] Revisar y aprobar PRs de Cirilo (Jurados, Sustentaciones, Actas y Reportes).
  * [ ] Resolver discrepancias de modelo de datos y llaves foráneas en `develop`.

---

## Semana 10: 03 de Agosto al 08 de Agosto
* Horas semanales: 24
* Horas acumuladas: 240
* Estado: En Progreso
* Entregables: Suite de Pruebas Automatizadas del Core (PHPUnit / Pest).

### Tareas y Actividades
* [ ] Pruebas Automatizadas Unitarias y Feature:
  * [x] Crear pruebas de autenticación y autorización (`AuthenticationTest.php`, `ProfileTest.php`).
  * [ ] Crear pruebas de CRUD de estudiantes y validaciones (`StudentTest.php`).
  * [ ] Crear pruebas del motor de graduación y cálculo de créditos (`GraduationTest.php`).
  * [x] Crear pruebas de verificación pública de diplomas (`PublicLookupTest.php`).

---

## Semana 11: 10 de Agosto al 15 de Agosto
* Horas semanales: 24
* Horas acumuladas: 264
* Estado: Pendiente
* Entregables: Auditoría de Seguridad, Prevención de Vulnerabilidades y Caching.

### Tareas y Actividades
* [ ] Auditoría de Seguridad:
  * [ ] Validar protección contra CSRF, XSS y SQL Injection en todos los formularios y endpoints.
  * [ ] Comprobar expiración segura de sesiones y rate limiting en login y consultas públicas.
* [ ] Caching y Optimización:
  * [ ] Implementar caché para mallas curriculares y catálogos estáticos.

---

## Semana 12: 17 de Agosto al 22 de Agosto
* Horas semanales: 24
* Horas acumuladas: 288
* Estado: Pendiente
* Entregables: Optimización de Base de Datos, Carga Ansiosa e Integración Global E2E.

### Tareas y Actividades
* [ ] Optimización de Consultas SQL:
  * [ ] Añadir índices compuestos en tablas pivote (`course_student`, `efsrt_student`).
  * [ ] Optimizar consultas con carga ansiosa (`with()`) erradicando el problema N+1.
* [ ] Integración Global del Sistema:
  * [ ] Ejecutar prueba integral con base de datos regenerada (`php artisan migrate:fresh --seed`).
  * [ ] Validar el flujo completo de titulación desde el registro de alumno hasta el grado final.

---

## Semana 13: 24 de Agosto al 29 de Agosto
* Horas semanales: 24
* Horas acumuladas: 312
* Estado: Pendiente
* Entregables: Pruebas de Carga, Estabilización de Release y Revisión de Integración Final.

### Tareas y Actividades
* [ ] Estabilización de la Versión Release:
  * [ ] Ejecutar pruebas de regresión en todos los módulos integrados.
  * [ ] Revisar consistencia de respuestas JSON y tiempos de respuesta de consultas.
  * [ ] Consolidar los pull requests finales en la rama `develop`.

---

## Semana 14: 31 de Agosto al 04 de Setiembre
* Horas semanales: 20
* Horas acumuladas: 332
* Estado: Pendiente
* Entregables: Cierre de Proyecto, Despliegue a Producción y Documentación Técnica Final.

### Tareas y Actividades
* [ ] Despliegue y Cierre Definitivo:
  * [ ] Documentar arquitectura técnica y variables de entorno para producción.
  * [ ] Realizar merge final de `develop` hacia la rama `main`.
  * [ ] Despliegue, configuración de certificados SSL y verificación de funcionamiento en servidor de producción.
