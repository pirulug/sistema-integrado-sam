# Checklist de Avance Detallado - CESAR (Full Stack)

Este documento contiene la hoja de ruta y especificaciones de desarrollo Full Stack organizadas por semanas, horas y fechas para el programador CESAR. Abarca el desarrollo integral (Base de Datos, Backend, Vistas Frontend Blade, Pruebas y Validaciones de Negocio) de las funcionalidades de Carreras Profesionales, Matrículas, Expedientes de Titulación, Proyectos de Tesis, Asignación de Asesores y Gestión Documental.

* Duración total asignada: 332 horas (13 semanas de 24 horas y Semana 14 de 20 horas)
* Fecha de inicio: 1 de Junio de 2026
* Cierre de proyecto: 04 de Setiembre de 2026
* Tecnologías: Laravel 12, PHP 8.x, MariaDB, Blade, Bootstrap 5, Vanilla JS, CSS Vanilla

---

## Semana 1: 01 de Junio al 06 de Junio
* Horas semanales: 24
* Horas acumuladas: 24
* Estado: En Progreso
* Entregables: Módulo de Carreras Profesionales Full Stack (BD, Modelos, Controlador y Vistas Blade).

### Tareas y Actividades
* [x] Base de Datos y Modelos de Carreras:
  * [x] Crear migración para tabla `careers` (`id`, `name`, `code`, `status`, timestamps).
  * [x] Configurar modelo `Career.php` con relación `belongsToMany` hacia `students` y `teachers`.
  * [x] Crear `CareerFactory.php` y `CareerSeeder.php` con las escuelas profesionales institucionales.
* [x] Backend de Gestión de Carreras:
  * [x] Implementar `CareerController.php` (métodos `index`, `create`, `store`, `edit`, `update`, `destroy`).
  * [x] Crear `StoreCareerRequest.php` y `UpdateCareerRequest.php` con validación de código único.
* [x] Frontend de Gestión de Carreras (Blade):
  * [x] Crear vista de catálogo de carreras (`resources/views/careers/index.blade.php`).
  * [x] Crear formulario de registro de carrera (`resources/views/careers/create.blade.php`).
  * [x] Crear formulario de edición de carrera (`resources/views/careers/edit.blade.php`).
  * [x] Implementar indicador de estado activo/inactivo con insignias visuales (badges).

---

## Semana 2: 08 de Junio al 13 de Junio
* Horas semanales: 24
* Horas acumuladas: 48
* Estado: Pendiente
* Entregables: Módulo de Matrículas Académicas Full Stack por Periodo.

### Tareas y Actividades
* [ ] Base de Datos y Modelos de Matrículas:
  * [ ] Crear migración para tabla `enrollments` (`id`, `student_id`, `career_id`, `academic_period`, `status`, `enrollment_date`, timestamps).
  * [ ] Configurar modelo `Enrollment.php` con relaciones `student()` y `career()`.
* [ ] Backend del Módulo de Matrículas:
  * [ ] Implementar `EnrollmentController.php` (registro de matrícula ordinaria y extraordinaria).
  * [ ] Validar que un estudiante no duplique matrícula en el mismo periodo para la misma carrera.
* [ ] Frontend del Módulo de Matrículas (Blade):
  * [ ] Crear vista de listado general de matrículas (`resources/views/enrollments/index.blade.php`).
  * [ ] Crear formulario de registro de matrícula (`resources/views/enrollments/create.blade.php`).
  * [ ] Añadir filtros por periodo académico (ej. 2026-I, 2026-II) y por escuela profesional.

---

## Semana 3: 15 de Junio al 20 de Junio
* Horas semanales: 24
* Horas acumuladas: 72
* Estado: Pendiente
* Entregables: Módulo de Expedientes de Titulación Full Stack - Parte 1 (Registro y Estructura Base).

### Tareas y Actividades
* [ ] Base de Datos y Modelos de Expedientes:
  * [ ] Crear migración para tabla `records` (`id`, `code`, `student_id`, `career_id`, `modality`, `status`, `opening_date`, timestamps).
  * [ ] Generar correlativo automático único para el número de expediente (ej. `EXP-2026-0001`).
  * [ ] Configurar modelo `Record.php` con relaciones a estudiante, carrera y documentos adjuntos.
* [ ] Backend del Módulo de Expedientes:
  * [ ] Implementar `RecordController.php` (métodos `index`, `create`, `store`).
  * [ ] Crear Form Request para validar modalidad de titulación (Tesis, Trabajo de Suficiencia, Experiencia Profesional).
* [ ] Frontend de Expedientes de Titulación (Blade):
  * [ ] Crear vista de listado de expedientes (`resources/views/records/index.blade.php`).
  * [ ] Crear formulario de apertura de nuevo expediente (`resources/views/records/create.blade.php`).
  * [ ] Diseñar filtros por estado de trámite y carrera profesional.

---

## Semana 4: 22 de Junio al 27 de Junio
* Horas semanales: 24
* Horas acumuladas: 96
* Estado: Pendiente
* Entregables: Módulo de Expedientes de Titulación Full Stack - Parte 2 (Máquina de Estados y Transiciones).

### Tareas y Actividades
* [ ] Lógica de Transición de Estados del Trámite:
  * [ ] Definir estados del expediente: `registrado`, `en_revision`, `observado`, `subsanado`, `aprobado`, `apto_sustentacion`.
  * [ ] Implementar reglas de validación en backend para transiciones de estado permitidas y prohibidas.
  * [ ] Crear tabla de historial de cambios de estado (`record_status_histories`).
* [ ] Backend de Actualización y Subsanación:
  * [ ] Implementar método para registrar observaciones y cambios de estado en `RecordController.php`.
  * [ ] Enviar notificaciones internas al estudiante ante observaciones o cambios de estado.
* [ ] Frontend de Gestión de Estados (Blade):
  * [ ] Diseñar modal interactivo para cambio de estado y registro de observaciones en el panel administrativo.
  * [ ] Implementar badges con códigos de color para cada estado del expediente.

---

## Semana 5: 29 de Junio al 04 de Julio
* Horas semanales: 24
* Horas acumuladas: 120
* Estado: Pendiente
* Entregables: Trazabilidad del Expediente y Línea de Tiempo Visual Full Stack.

### Tareas y Actividades
* [ ] Backend de Consulta de Trazabilidad:
  * [ ] Implementar método `show` en `RecordController.php` con carga eager de todo el historial de eventos.
  * [ ] Crear endpoint para consulta de seguimiento por parte del estudiante autenticado.
* [ ] Frontend de Línea de Tiempo (Timeline en Blade):
  * [ ] Crear vista de detalle y seguimiento del expediente (`resources/views/records/show.blade.php`).
  * [ ] Diseñar componente de línea de tiempo visual (Timeline) mostrando cada fase completada y pendiente.
  * [ ] Incluir panel de observaciones con fecha, usuario evaluador y comentarios de subsanación.

---

## Semana 6: 06 de Julio al 11 de Julio
* Horas semanales: 24
* Horas acumuladas: 144
* Estado: Pendiente
* Entregables: Módulo de Proyectos de Tesis Full Stack - Parte 1 (Registro de Plan y Líneas de Investigación).

### Tareas y Actividades
* [ ] Base de Datos y Modelos de Proyectos de Tesis:
  * [ ] Crear migración para tabla `thesis_projects` (`id`, `record_id`, `title`, `research_line`, `abstract`, `status`, `submission_date`, timestamps).
  * [ ] Configurar modelo `ThesisProject.php` con relaciones `record()` y `advisor()`.
* [ ] Backend de Proyectos de Tesis:
  * [ ] Implementar `ThesisProjectController.php` (métodos `index`, `create`, `store`).
  * [ ] Validar unicidad del título y pertenencia a las líneas de investigación institucionales.
* [ ] Frontend de Proyectos de Tesis (Blade):
  * [ ] Crear vista de catálogo de proyectos de investigación (`resources/views/thesis_projects/index.blade.php`).
  * [ ] Crear formulario de registro del plan de tesis (`resources/views/thesis_projects/create.blade.php`).
  * [ ] Implementar campos enriquecidos para resumen, objetivos y justificación.

---

## Semana 7: 13 de Julio al 18 de Julio
* Horas semanales: 24
* Horas acumuladas: 168
* Estado: Pendiente
* Entregables: Módulo de Proyectos de Tesis Full Stack - Parte 2 (Historial de Versiones y Modificaciones).

### Tareas y Actividades
* [ ] Backend de Versionado y Modificación de Proyectos:
  * [ ] Crear tabla para control de versiones del proyecto de tesis (`thesis_versions`).
  * [ ] Implementar métodos `edit` y `update` en `ThesisProjectController.php`.
  * [ ] Registrar el historial de cambios de título, metodología y objetivos con autoría y fecha.
* [ ] Frontend de Detalle y Versiones del Proyecto (Blade):
  * [ ] Crear vista de ficha del proyecto de tesis (`resources/views/thesis_projects/show.blade.php`).
  * [ ] Crear vista de comparación de versiones del plan de tesis.
  * [ ] Diseñar botones de descarga para versiones anteriores del documento.

---

## Semana 8: 20 de Julio al 25 de Julio
* Horas semanales: 24
* Horas acumuladas: 192
* Estado: Pendiente
* Entregables: Módulo de Asignación de Asesores Full Stack - Parte 1 (Solicitud y Aprobación).

### Tareas y Actividades
* [ ] Base de Datos y Modelos de Asesorías:
  * [ ] Crear migración para tabla `advisorships` (`id`, `thesis_project_id`, `teacher_id`, `status`, `assignment_date`, `resolution_number`, timestamps).
  * [ ] Configurar modelo `Advisorship.php` con relaciones a proyecto de tesis y docente asesor.
* [ ] Backend de Solicitud y Asignación de Asesor:
  * [ ] Implementar `AdvisorAssignmentController.php`.
  * [ ] Validar que el docente no exceda la carga máxima permitida de asesorías simultáneas.
  * [ ] Implementar flujo de aprobación o rechazo de solicitud de asesoría.
* [ ] Frontend de Asignación de Asesores (Blade):
  * [ ] Crear vista de gestión de asignaciones (`resources/views/advisors/assignments.blade.php`).
  * [ ] Crear formulario de propuesta y selección de docente asesor con filtro por especialidad.

---

## Semana 9: 27 de Julio al 01 de Agosto
* Horas semanales: 24
* Horas acumuladas: 216
* Estado: Pendiente
* Entregables: Módulo de Asesorías Full Stack - Parte 2 (Panel del Asesor y Emisión de Dictámenes).

### Tareas y Actividades
* [ ] Backend del Panel de Asesoría y Dictámenes:
  * [ ] Implementar `AdvisorDashboardController.php` con listado de proyectos asignados al docente autenticado.
  * [ ] Implementar método para emitir informe de conformidad o dictamen de aprobación de tesis.
  * [ ] Registrar fecha de aprobación de informe final por parte del asesor.
* [ ] Frontend del Panel del Asesor (Blade):
  * [ ] Crear vista de panel del asesor (`resources/views/advisors/dashboard.blade.php`).
  * [ ] Diseñar interfaz para revisión de borradores y registro de observaciones directas.
  * [ ] Crear formulario para emisión y firma digital/código del dictamen de asesoría.

---

## Semana 10: 03 de Agosto al 08 de Agosto
* Horas semanales: 24
* Horas acumuladas: 240
* Estado: Pendiente
* Entregables: Módulo de Gestión Documental Full Stack (Carga Segura de Tesis, Anexos y Validaciones).

### Tareas y Actividades
* [ ] Backend de Gestión Documental y Almacenamiento Seguro:
  * [ ] Implementar `DocumentController.php` para carga y descarga de archivos PDF.
  * [ ] Configurar almacenamiento en disco local seguro (`storage/app/documents/`).
  * [ ] Validar tipos MIME permitidos (PDF), tamaño máximo (máx. 25MB) y sanitización de nombres de archivo.
* [ ] Frontend de Carga y Gestión de Documentos (Blade):
  * [ ] Diseñar componente de carga de archivos (Drag and Drop / Selector de archivo).
  * [ ] Crear vista de repositorio de documentos del expediente (`resources/views/documents/index.blade.php`).
  * [ ] Implementar visor integrado de archivos PDF o enlace seguro de descarga con token temporal.

---

## Semana 11: 10 de Agosto al 15 de Agosto
* Horas semanales: 24
* Horas acumuladas: 264
* Estado: Pendiente
* Entregables: Pruebas Automatizadas de Expedientes y Tesis, y Validación de Reglas de Negocio.

### Tareas y Actividades
* [ ] Pruebas Automatizadas (PHPUnit / Pest):
  * [ ] Crear pruebas unitarias para el flujo completo del expediente (`RecordTest.php`).
  * [ ] Crear pruebas para la máquina de estados y transiciones inválidas (`RecordStatusTest.php`).
  * [ ] Crear pruebas para la carga máxima de asesorías por docente (`AdvisorshipTest.php`).
  * [ ] Crear pruebas para la subida segura de archivos y validación de extensiones (`DocumentUploadTest.php`).

---

## Semana 12: 17 de Agosto al 22 de Agosto
* Horas semanales: 24
* Horas acumuladas: 288
* Estado: Pendiente
* Entregables: Pruebas Funcionales End-to-End, Refactorización e Integración con Módulos Core.

### Tareas y Actividades
* [ ] Integración y Control de Calidad:
  * [ ] Validar integración completa de expedientes con los estudiantes y planes curriculares de Guido.
  * [ ] Validar integración de expedientes aprobados hacia los módulos de jurados y sustentaciones de Cirilo.
  * [ ] Optimizar consultas complejas en el listado de expedientes y proyectos.

---

## Semana 13: 24 de Agosto al 29 de Agosto
* Horas semanales: 24
* Horas acumuladas: 312
* Estado: Pendiente
* Entregables: Pruebas Integrales de Usuario, Ajustes de Rendimiento y Refinamiento Documental.

### Tareas y Actividades
* [ ] Pruebas de Usuario y Validación de Casos Extremos:
  * [ ] Probar casos de estudiantes con cambios de tema de tesis o cambio de asesor.
  * [ ] Validar permisos y restricciones de descarga para documentos confidenciales.
  * [ ] Refactorizar componentes Blade para reutilización.

---

## Semana 14: 31 de Agosto al 04 de Setiembre
* Horas semanales: 20
* Horas acumuladas: 332
* Estado: Pendiente
* Entregables: Manual de Usuario de Trámites de Titulación y Cierre de Entregables.

### Tareas y Actividades
* [ ] Cierre y Documentación de Procesos:
  * [ ] Redactar guía funcional y manual de usuario para el registro de expedientes y planes de tesis.
  * [ ] Realizar verificación final de datos de prueba y limpieza de archivos temporales.
  * [ ] Entrega final de entregables y aprobación de cierre.
