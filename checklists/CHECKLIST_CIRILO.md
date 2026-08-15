# Checklist de Avance Detallado - CIRILO (Full Stack)

Este documento contiene la hoja de ruta y especificaciones de desarrollo Full Stack organizadas por semanas, horas y fechas para el programador CIRILO. Abarca el desarrollo integral (Base de Datos, Backend, Vistas Frontend Blade, Pruebas y Reportes) de las funcionalidades del Sistema de Diseño Base, Docentes, Prácticas Formativas (EFSRT), Jurados de Sustentación, Programación de Sustentaciones con Actas y Dashboard / Reportes Estadísticos.

* Duración total asignada: 332 horas (13 semanas de 24 horas y Semana 14 de 20 horas)
* Fecha de inicio: 1 de Junio de 2026
* Cierre de proyecto: 04 de Setiembre de 2026
* Tecnologías: Laravel 12, PHP 8.x, MariaDB, Blade, Bootstrap 5, Vanilla JS, CSS Vanilla, Chart.js

---

## Semana 1: 01 de Junio al 06 de Junio
* Horas semanales: 24
* Horas acumuladas: 24
* Estado: Pendiente
* Entregables: Sistema de Diseño Base y Plantilla Principal del Sistema (`layouts/app.blade.php`).

### Tareas y Actividades
* [ ] Configuración del sistema de diseño (CSS Base y Tokens):
  * [ ] Definir variables CSS personalizadas en `:root` (paleta corporativa, tipografía Inter, sombras y radios).
  * [ ] Crear archivo de estilos base `public/css/custom.css` sin sobrecargar frameworks externos.
  * [ ] Establecer estilos de botones, tarjetas flotantes y tablas responsivas.
* [ ] Maquetación del Layout Principal (`resources/views/layouts/app.blade.php`):
  * [ ] Crear estructura HTML5 con `meta viewport` y `meta csrf-token`.
  * [ ] Diseñar panel lateral izquierdo (sidebar) con navegación para todos los módulos del sistema.
  * [ ] Diseñar barra superior (navbar) con menú hamburguesa colapsable para móviles.
  * [ ] Implementar dropdown de perfil y botón de cierre de sesión seguro.
  * [ ] Maquetar contenedor principal de contenido `@yield("content")` y bloques de alertas flash.

---

## Semana 2: 08 de Junio al 13 de Junio
* Horas semanales: 24
* Horas acumuladas: 48
* Estado: Pendiente
* Entregables: Dashboard Principal Full Stack y Landing Page Informativa.

### Tareas y Actividades
* [ ] Backend del Dashboard y Landing:
  * [ ] Implementar controlador de inicio (`HomeController.php` / ruta `/dashboard`).
  * [ ] Consultar contadores clave en tiempo real (total estudiantes, docentes, expedientes en trámite, sustentaciones programadas).
* [ ] Frontend del Dashboard y Landing Page (Blade):
  * [ ] Crear vista del Dashboard administrativo (`resources/views/dashboard.blade.php`).
  * [ ] Diseñar tarjetas métricas (KPIs) con indicadores rápidos y accesos directos a módulos.
  * [ ] Crear vista pública de aterrizaje (`resources/views/landing.blade.php`) con información institucional y consulta rápida.

---

## Semana 3: 15 de Junio al 20 de Junio
* Horas semanales: 24
* Horas acumuladas: 72
* Estado: En Progreso
* Entregables: Módulo de Docentes Full Stack (BD, Modelos, Controlador y Vistas Blade).

### Tareas y Actividades
* [x] Base de Datos y Modelos de Docentes:
  * [x] Crear migración para tabla `teachers` (`id`, `name`, `document_number`, `email`, `phone`, `specialty`, `status`, `hire_date`, timestamps).
  * [x] Crear tabla pivote `career_teacher` para asociar docentes a departamentos de carreras.
  * [x] Configurar modelo `Teacher.php` con relación `careers()`.
  * [x] Crear `TeacherFactory.php` y `TeacherSeeder.php`.
* [x] Backend de Gestión Docente:
  * [x] Implementar `TeacherController.php` (CRUD completo: `index`, `create`, `store`, `edit`, `update`, `destroy`).
  * [x] Crear Form Requests: `StoreTeacherRequest.php` y `UpdateTeacherRequest.php`.
* [x] Frontend de Gestión Docente (Blade):
  * [x] Crear vista de catálogo de docentes (`resources/views/teachers/index.blade.php`).
  * [x] Crear formularios de registro y edición (`resources/views/teachers/create.blade.php` y `edit.blade.php`).
  * [x] Añadir filtros por especialidad y departamento académico.

---

## Semana 4: 22 de Junio al 27 de Junio
* Horas semanales: 24
* Horas acumuladas: 96
* Estado: Pendiente
* Entregables: Módulo de EFSRT (Prácticas Formativas en Situaciones Reales de Trabajo) Full Stack - Parte 1.

### Tareas y Actividades
* [ ] Base de Datos y Modelos de EFSRT:
  * [ ] Crear migración para tabla `efsrts` (`id`, `student_id`, `module_number`, `company_name`, `hours`, `start_date`, `end_date`, `status`, timestamps).
  * [ ] Configurar modelo `Efsrt.php` con relaciones a estudiante.
  * [ ] Crear seeder con registros de prueba para los 3 módulos formativos reglamentarios (EFSRT I, II, III).
* [ ] Backend del Módulo de EFSRT:
  * [ ] Implementar `EfsrtController.php` (métodos `index`, `create`, `store`).
  * [ ] Validar que las horas acreditadas cumplan con el mínimo requerido por módulo.
* [ ] Frontend del Módulo de EFSRT (Blade):
  * [ ] Crear vista de listado de prácticas de estudiantes (`resources/views/efsrts/index.blade.php`).
  * [ ] Crear formulario de registro de práctica preprofesional (`resources/views/efsrts/create.blade.php`).

---

## Semana 5: 29 de Junio al 04 de Julio
* Horas semanales: 24
* Horas acumuladas: 120
* Estado: Pendiente
* Entregables: Módulo de EFSRT Full Stack - Parte 2 (Control de Horas, Validación y Certificados).

### Tareas y Actividades
* [ ] Backend de Aprobación de Prácticas:
  * [ ] Implementar métodos `edit`, `update` y `destroy` en `EfsrtController.php`.
  * [ ] Implementar método para actualizar estado del módulo formativo (`updateEfsrt`).
  * [ ] Integrar verificación de los 3 módulos concluidos como requisito para la titulación.
* [ ] Frontend de Validación de Prácticas (Blade):
  * [ ] Crear vista de detalle y seguimiento de módulos EFSRT (`resources/views/efsrts/show.blade.php`).
  * [ ] Crear componentes visuales para aprobación rápida de horas y subida de constancia de prácticas.
  * [ ] Diseñar resumen de cumplimiento de prácticas en la ficha del estudiante.

---

## Semana 6: 06 de Julio al 11 de Julio
* Horas semanales: 24
* Horas acumuladas: 144
* Estado: Pendiente
* Entregables: Módulo de Jurados de Sustentación Full Stack - Parte 1 (Habilitación y Registro).

### Tareas y Actividades
* [ ] Base de Datos y Modelos de Jurados:
  * [ ] Crear migración para tabla `jurors` (`id`, `teacher_id`, `academic_degree`, `specialty_area`, `max_assignments`, `is_active`, timestamps).
  * [ ] Configurar modelo `Juror.php` con relación `teacher()` y `defenses()`.
* [ ] Backend de Habilitación de Jurados:
  * [ ] Implementar `JurorController.php` (métodos `index`, `create`, `store`).
  * [ ] Validar grado académico mínimo (Maestría/Doctorado) para habilitación como jurado evaluador.
* [ ] Frontend de Jurados Evaluadores (Blade):
  * [ ] Crear vista de padrón de jurados habilitados (`resources/views/jurors/index.blade.php`).
  * [ ] Crear formulario de registro y asignación de cupos de sustentación (`resources/views/jurors/create.blade.php`).

---

## Semana 7: 13 de Julio al 18 de Julio
* Horas semanales: 24
* Horas acumuladas: 168
* Estado: Pendiente
* Entregables: Módulo de Jurados de Sustentación Full Stack - Parte 2 (Conformación del Tribunal Evaluador).

### Tareas y Actividades
* [ ] Backend de Conformación de Tribunal:
  * [ ] Crear tabla pivote para asignación de miembros del jurado a sustentaciones (`defense_juror`).
  * [ ] Definir cargos: Presidente, Secretario y Vocal.
  * [ ] Implementar validación para impedir que el asesor de la tesis sea miembro del jurado dictaminador.
* [ ] Frontend de Designación de Tribunal (Blade):
  * [ ] Crear interfaz interactiva para selección de jurados (`resources/views/jurors/assign.blade.php`).
  * [ ] Mostrar carga actual de sustentaciones de cada docente para balancear asignaciones.
  * [ ] Generar resolución o notificación formal para los miembros del tribunal.

---

## Semana 8: 20 de Julio al 25 de Julio
* Horas semanales: 24
* Horas acumuladas: 192
* Estado: Pendiente
* Entregables: Módulo de Sustentaciones Full Stack - Parte 1 (Programación de Fechas, Horas y Aulas).

### Tareas y Actividades
* [ ] Base de Datos y Modelos de Sustentaciones:
  * [ ] Crear migración para tabla `defenses` (`id`, `record_id`, `defense_date`, `defense_time`, `classroom_or_link`, `status`, `result`, `final_score`, timestamps).
  * [ ] Configurar modelo `Defense.php` con relaciones a expediente y jurados.
* [ ] Backend de Programación de Sustentaciones:
  * [ ] Implementar `DefenseController.php` (métodos `index`, `create`, `store`).
  * [ ] Validar disponibilidad de aula/enlace y evitar cruce de horarios entre jurados.
* [ ] Frontend de Calendario de Sustentaciones (Blade):
  * [ ] Crear vista de agenda y programación (`resources/views/defenses/index.blade.php`).
  * [ ] Crear formulario de programación de fecha y recinto (`resources/views/defenses/create.blade.php`).
  * [ ] Diseñar vista tipo calendario o tarjetas cronológicas.

---

## Semana 9: 27 de Julio al 01 de Agosto
* Horas semanales: 24
* Horas acumuladas: 216
* Estado: Pendiente
* Entregables: Módulo de Sustentaciones Full Stack - Parte 2 (Actas de Calificación y Dictamen Final).

### Tareas y Actividades
* [ ] Backend de Calificación y Emisión de Actas:
  * [ ] Implementar método para registrar calificaciones individuales de cada jurado en `DefenseController.php`.
  * [ ] Calcular promedio final y dictamen: Aprobado por Unanimidad, Aprobado por Mayoría o Desaprobado.
  * [ ] Generar número correlativo de acta de sustentación y código hash de verificación.
* [ ] Frontend de Evaluación y Acta Oficial (Blade):
  * [ ] Crear vista de evaluación y acta digital (`resources/views/defenses/show.blade.php`).
  * [ ] Diseñar formulario de rúbrica de calificación para jurados.
  * [ ] Diseñar plantilla imprimible en formato oficial para el acta de sustentación.

---

## Semana 10: 03 de Agosto al 08 de Agosto
* Horas semanales: 24
* Horas acumuladas: 240
* Estado: Pendiente
* Entregables: Módulo de Reportes Estadísticos Full Stack - Parte 1 (Indicadores Gráficos de Titulación).

### Tareas y Actividades
* [ ] Backend de Procesamiento Estadístico:
  * [ ] Implementar `ReportController.php` con consultas de agregación SQL (conteo por modalidad, por año y por carrera).
  * [ ] Crear endpoint de datos estadísticos formateados en JSON.
* [ ] Frontend de Gráficos Estadísticos (Blade + Vanilla JS / Chart.js):
  * [ ] Crear vista de reportes de titulación (`resources/views/reports/degrees.blade.php`).
  * [ ] Diseñar gráficos interactivos de barras, líneas y sectores circulares.
  * [ ] Añadir filtros por rango de fechas y escuela profesional.

---

## Semana 11: 10 de Agosto al 15 de Agosto
* Horas semanales: 24
* Horas acumuladas: 264
* Estado: Pendiente
* Entregables: Módulo de Reportes Estadísticos Full Stack - Parte 2 (Alertas de Deserción y Exportación PDF).

### Tareas y Actividades
* [ ] Backend de Detección de Deserción y Exportación:
  * [ ] Implementar algoritmo para identificar estudiantes con trámites estancados o sin matrícula consecutiva.
  * [ ] Implementar generación y descarga de reportes ejecutivos en PDF.
* [ ] Frontend de Alertas de Deserción (Blade):
  * [ ] Crear vista de alertas de deserción estudiantil (`resources/views/reports/dropout.blade.php`).
  * [ ] Diseñar tabla de alertas priorizadas con botones de acción para seguimiento.
  * [ ] Añadir botón de exportación rápida a PDF / Excel.

---

## Semana 12: 17 de Agosto al 22 de Agosto
* Horas semanales: 24
* Horas acumuladas: 288
* Estado: Pendiente
* Entregables: Pruebas de Usabilidad UI/UX, Pruebas Automatizadas y Ajustes de Responsive.

### Tareas y Actividades
* [ ] Pruebas Automatizadas y de Interfaz:
  * [ ] Crear pruebas para el registro y validación de docentes (`TeacherTest.php`).
  * [ ] Crear pruebas para la programación de sustentaciones y actas (`DefenseTest.php`).
  * [ ] Crear pruebas para los módulos de EFSRT (`EfsrtTest.php`).
* [ ] Pulido y Optimización Frontend:
  * [ ] Verificar adaptabilidad y navegación fluida en dispositivos móviles, tablets y monitores de escritorio.
  * [ ] Optimizar tiempo de carga de gráficos y componentes JS.

---

## Semana 13: 24 de Agosto al 29 de Agosto
* Horas semanales: 24
* Horas acumuladas: 312
* Estado: Pendiente
* Entregables: Refactorización de Componentes de Reportes y Validación Cruzada de Interfaces.

### Tareas y Actividades
* [ ] Ajustes de Accesibilidad y Consistencia UI:
  * [ ] Verificar contraste de colores y compatibilidad con temas claros y oscuros.
  * [ ] Validar renderizado de tablas en reportes impresos.
  * [ ] Realizar pruebas de rendimiento de los paneles gráficos con volumen alto de datos.

---

## Semana 14: 31 de Agosto al 04 de Setiembre
* Horas semanales: 20
* Horas acumuladas: 332
* Estado: Pendiente
* Entregables: Cierre de Entregables de Interfaz y Documentación de Vistas y Componentes.

### Tareas y Actividades
* [ ] Cierre y Documentación de Vistas:
  * [ ] Documentar la guía de componentes UI y clases CSS personalizadas para mantenimiento futuro.
  * [ ] Realizar verificación final de rutas frontend y enlaces de navegación del sidebar.
  * [ ] Entrega final y visto bueno de interfaces.
