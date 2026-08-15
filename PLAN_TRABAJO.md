# Sistema de Titulación (SAM)

## Plan de Trabajo del Equipo - Esquema Full Stack por Funcionalidades

### Tecnologías

* Laravel 12
* PHP 8.x
* MariaDB
* Bootstrap 5
* Blade
* Vanilla JavaScript / CSS Vanilla
* Git y GitHub

* Duración total: 332 horas por integrante (13 semanas de 24 horas y Semana 14 de 20 horas)
* Fecha de inicio: 1 de Junio de 2026
* Cierre de proyecto: 04 de Setiembre de 2026

---

# Integrante 1: GUIDO (Líder Técnico - Full Stack)

## Funcionalidades Asignadas

### 1. Arquitectura Base y Seguridad
* Configuración inicial del repositorio, flujo Git y despliegue
* Módulo de Autenticación y gestión de sesiones
* Sistema de Roles y Permisos (RBAC: Admin, Docente, Asesor, Jurado, Estudiante)
* Políticas de acceso (Laravel Policies) y auditoría de seguridad

### 2. Módulo de Estudiantes y Docentes
* Base de Datos, Modelos Eloquent `Student.php` y `Teacher.php` con migraciones
* CRUD completo de estudiantes (Backend y Vistas Blade)
* Ficha académica integral, historial de estudios y soporte multi-carrera
* CRUD completo de docentes con especialidades y asignaciones

### 3. Malla Curricular y Planes de Estudio
* Módulo de Planes de Estudio (`Curriculum.php` - CRUD y vigencia)
* Módulo de Cursos (`Course.php` - asignaturas, créditos y periodos I al VI)
* Vista interactiva de la malla curricular agrupada por ciclos
* Módulo de EFSRT (`Efsrt.php` - módulos formativos y prácticas)

### 4. Motor de Graduación y Verificación de Requisitos
* Servicio de cálculo de porcentaje de avance curricular y créditos
* Panel de validación interactiva de requisitos de titulación
* Emisión del estado de Titulado y consulta pública de diplomas emitidos

### 5. Liderazgo Técnico
* Revisión de Pull Requests y resolución de conflictos
* Suite de pruebas automatizadas del core académico (PHPUnit / Pest)
* Optimización de consultas SQL y auditoría final

---

# Integrante 2: CESAR (Full Stack)

## Funcionalidades Asignadas

### 1. Carreras Profesionales y Matrículas
* Módulo de Carreras Profesionales (`Career.php` - CRUD, códigos y estados)
* Módulo de Matrículas Académicas por periodo lectivo (registro ordinario/extraordinario)

### 2. Expedientes de Titulación
* Registro de expedientes con generación de código correlativo único
* Máquina de estados del expediente (registrado, en revisión, observado, subsanado, aprobado, apto)
* Historial de auditoría de cambios de estado y observaciones

### 3. Trazabilidad y Seguimiento
* Vista de seguimiento del expediente con componente de Línea de Tiempo (Timeline)
* Panel de notificaciones internas de estado para el estudiante

### 4. Proyectos de Tesis e Investigación
* Registro y aprobación de planes de tesis por línea de investigación
* Control de versiones del proyecto e historial de modificaciones

### 5. Asesorías y Gestión Documental
* Solicitud y asignación de docentes asesores (control de carga máxima)
* Panel del asesor para revisión de borradores y emisión de dictámenes de conformidad
* Carga segura y versionado de archivos PDF (tesis, anexos, constancias)
* Pruebas funcionales de expedientes y manual de usuario

---

# Integrante 3: CIRILO (Full Stack)

## Funcionalidades Asignadas

### 1. Sistema de Diseño Base y Layout
* Variables CSS personalizadas, tokens de diseño y componentes UI reutilizables
* Layout principal responsive (`resources/views/layouts/app.blade.php`)
* Barra de navegación (navbar), panel lateral (sidebar) y menú móvil

### 2. Dashboard Principal
* Dashboard administrativo con métricas rápidas (KPIs) en tiempo real
* Landing page informativa de acceso público

### 3. Jurados de Sustentación
* Padrón de jurados habilitados y balanceo de carga de sustentaciones
* Conformación de tribunales evaluadores (Presidente, Secretario, Vocal)

### 4. Sustentaciones y Actas Oficiales
* Programación de fecha, hora y recinto (aula física / virtual)
* Rúbrica de calificación individual y emisión de actas correlativas con código de verificación

### 5. Reportes Estadísticos y Alertas
* Gráficos interactivos de titulación por carrera y año (Chart.js / Vanilla JS)
* Sistema de alertas tempranas de deserción estudiantil y exportación a PDF

---

# Flujo de Trabajo Git y Ramas

## Ramas Principales
* `main`: Rama de producción estable.
* `develop`: Rama de integración principal.

## Ramas por Funcionalidad (Feature Branches)
* `feature/guido-core-academico`
* `feature/cesar-expedientes-tesis`
* `feature/cirilo-jurados-sustentaciones`

---

# Cronograma General Resumido

| Semanas | Periodo | Hitos Principales |
| :---: | :---: | :--- |
| **Semanas 1 - 2** | 01 Jun - 13 Jun | Arquitectura base, autenticación, dashboard, carreras y matrículas. |
| **Semanas 3 - 4** | 15 Jun - 27 Jun | CRUD de estudiantes, docentes, planes de estudio, expedientes (fase 1) y EFSRT (fase 1). |
| **Semanas 5 - 6** | 29 Jun - 11 Jul | Malla de cursos, graduación básica, proyectos de tesis, y habilitación de jurados. |
| **Semanas 7 - 8** | 13 Jul - 25 Jul | Refactorización de APIs, versionado de tesis, asignación de asesores, tribunal de jurados y sustentaciones (fase 1). |
| **Semanas 9 - 10** | 27 Jul - 08 Ago | Políticas de seguridad, panel del asesor, actas de sustentación, gestión documental PDF y reportes estadísticos. |
| **Semanas 11 - 12** | 10 Ago - 22 Ago | Alertas de deserción, suite de pruebas automatizadas (unitarias/integración/UI), optimización y refactorización. |
| **Semanas 13 - 14** | 24 Ago - 04 Set | Pruebas integrales de carga, manuales de usuario, documentación técnica, merge a `main` y despliegue a producción. |
