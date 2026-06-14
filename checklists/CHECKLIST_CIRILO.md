# Checklist de Avance Detallado - CIRILO (Frontend, Interfaces y Vistas)

Este documento contiene la hoja de ruta, especificaciones de diseño, estructura de vistas Blade y tareas de maquetación en frontend para el programador CIRILO, encargado del diseño responsive con Bootstrap 5, la navegación general, la usabilidad de formularios y los gráficos de reporte.

* Duración total asignada: 290 horas (4 horas diarias, 6 días a la semana, excepto la última semana de 2 horas)
* Tecnología: Laravel Blade, Bootstrap 5, HTML5, CSS3, JavaScript (Chart.js / Vanilla JS)



## Semana 1: 01 de Junio al 06 de Junio
* Horas semanales: 24
* Horas acumuladas: 24
* Entregables: Configuración del Sistema de Diseño (index.css) y Plantilla Principal del Sistema (layouts/app.blade.php).

### Tareas y Actividades
* [ ] Configuración del sistema de diseño (Diseño consistente):
  * [ ] Definir variables CSS en :root para colores primarios (marca y botones de acción principal).
  * [ ] Definir variables CSS para estados de éxito (success) y colores de fondo complementarios.
  * [ ] Definir variables CSS para estados de advertencia (warning) y estados de error (danger).
  * [ ] Importar la familia tipográfica Inter mediante Google Fonts en el encabezado.
  * [ ] Establecer el peso de fuente 300 (Light) para textos secundarios e informativos.
  * [ ] Establecer el peso de fuente 400 (Regular) para textos comunes del cuerpo de página.
  * [ ] Establecer el peso de fuente 500 (Medium) para etiquetas de formulario y enlaces de navegación.
  * [ ] Establecer el peso de fuente 600 (Semibold) para subtítulos y tarjetas informativas.
  * [ ] Establecer el peso de fuente 700 (Bold) para títulos de páginas y secciones principales.
  * [ ] Configurar el valor de border-radius global de 8px para tarjetas y botones.
  * [ ] Configurar sombras sutiles (box-shadow) para paneles y tarjetas flotantes.
  * [ ] Definir puntos de quiebre (breakpoints) responsive basados en la grilla de Bootstrap 5.
* [ ] Maquetación de la Plantilla Principal (app.blade.php):
  * [ ] Declarar estructura doctype HTML5 y definir idioma dinámico con app()->getLocale().
  * [ ] Configurar etiqueta meta charset a UTF-8 para evitar problemas de codificación de caracteres.
  * [ ] Agregar meta viewport con la escala inicial de escala de dispositivo para responsive móvil.
  * [ ] Insertar etiqueta meta csrf-token para permitir la inyección segura de token en llamadas AJAX.
  * [ ] Estructurar la sección del head con el título dinámico de la aplicación.
  * [ ] Enlazar la hoja de estilos externa del framework Bootstrap 5.
  * [ ] Crear sección de estilos personalizados para sobreescribir estilos base de Bootstrap.
  * [ ] Definir reglas para la altura mínima del sidebar (min-height: 100vh) para navegadores.
  * [ ] Diseñar el panel lateral izquierdo (sidebar) de navegación general con clase d-none d-md-block.
  * [ ] Implementar el logotipo o isotipo del sistema en la parte superior del sidebar.
  * [ ] Enlazar el menú de inicio del sistema apuntando al Dashboard principal.
  * [ ] Enlazar la pestaña del menú dedicada a la gestión de Estudiantes.
  * [ ] Enlazar la pestaña del menú dedicada a la gestión de Docentes.
  * [ ] Enlazar la pestaña del menú dedicada a la gestión de Carreras Profesionales.
  * [ ] Enlazar la pestaña del menú dedicada a la gestión de Matrículas Académicas.
  * [ ] Enlazar la pestaña del menú dedicada a la gestión de Expedientes de Titulación.
  * [ ] Enlazar la pestaña del menú dedicada a la gestión de Jurados de Sustentación.
  * [ ] Enlazar la pestaña del menú dedicada a la visualización de Reportes Estadísticos.
  * [ ] Maquetar la barra de navegación superior (navbar) para cabecera en dispositivos medianos y grandes.
  * [ ] Añadir menú de hamburguesa colapsable para visualización móvil (d-md-none).
  * [ ] Crear el contenedor para el dropdown de configuración y perfil del usuario autenticado.
  * [ ] Mostrar dinámicamente el nombre del usuario conectado mediante Auth::user()->name.
  * [ ] Añadir formulario de logout con el método POST y la directiva @csrf de Laravel.
  * [ ] Insertar botón de confirmación en el dropdown para activar la petición de logout.
  * [ ] Configurar contenedor principal de contenido mediante la directiva yield('content').
  * [ ] Maquetar alertas flash condicionales para mensajes de éxito con clases de alerta de Bootstrap.
  * [ ] Maquetar alertas flash condicionales para mensajes de error con clases de alerta de Bootstrap.
  * [ ] Insertar los scripts JavaScript de Bootstrap en la parte inferior del documento.



## Semana 2: 08 de Junio al 13 de Junio
* Horas semanales: 24
* Horas acumuladas: 48
* Entregables: Vista del Dashboard General (home.blade.php) y Maquetación del Menú Responsivo Móvil.

### Tareas y Actividades
* [ ] Diseño y maquetación de la vista del Dashboard (home.blade.php):
  * [ ] Extender de la plantilla base layouts.app mediante la directiva extends.
  * [ ] Abrir sección de contenido principal mediante la directiva section('content').
  * [ ] Diseñar contenedor tipo container-fluid para ajustar el ancho a la pantalla del usuario.
  * [ ] Crear el título principal del panel en formato h1 con clase text-dark.
  * [ ] Diseñar la grilla responsiva de tarjetas informativas utilizando row-cols-1, row-cols-md-2 y row-cols-lg-4.
  * [ ] Tarjeta de métrica de Estudiantes Matriculados:
    * [ ] Crear tarjeta de Bootstrap con borde izquierdo azul (border-start border-primary border-4).
    * [ ] Mostrar etiqueta descriptiva en texto gris de tamaño pequeño (text-uppercase text-muted).
    * [ ] Pintar dinámicamente la cifra total de estudiantes matriculados en formato grande.
    * [ ] Añadir enlace con clase link-primary para redirigir a la lista de estudiantes.
  * [ ] Tarjeta de métrica de Egresados Totales:
    * [ ] Crear tarjeta de Bootstrap con borde izquierdo verde (border-start border-success border-4).
    * [ ] Mostrar etiqueta descriptiva para egresados universitarios.
    * [ ] Pintar la cifra total de egresados obtenidos de la base de datos.
    * [ ] Añadir enlace para navegar directamente al panel de egresados.
  * [ ] Tarjeta de métrica de Trámites de Título:
    * [ ] Crear tarjeta de Bootstrap con borde izquierdo amarillo (border-start border-warning border-4).
    * [ ] Mostrar etiqueta descriptiva para expedientes iniciados en el trámite.
    * [ ] Pintar la cifra de expedientes en revisión o en proceso.
    * [ ] Añadir enlace para navegar a la sección de expedientes.
  * [ ] Tarjeta de métrica de Alertas de Deserción:
    * [ ] Crear tarjeta de Bootstrap con borde izquierdo rojo (border-start border-danger border-4).
    * [ ] Mostrar etiqueta descriptiva para estudiantes identificados en riesgo.
    * [ ] Pintar la cifra de alertas activas calculadas por el sistema.
    * [ ] Añadir enlace para navegar al panel de reportes de deserción.
  * [ ] Diseño del bloque de visualización de información del Dashboard:
    * [ ] Crear estructura row con dos columnas: col-lg-8 para datos y col-lg-4 para gráficos.
    * [ ] Panel izquierdo: Tabla de Matrículas Recientes:
      * [ ] Crear tarjeta de Bootstrap para contener la tabla de registros.
      * [ ] Definir encabezado de la tarjeta con estilo minimalista.
      * [ ] Estructurar tabla responsive mediante la clase table-responsive.
      * [ ] Definir encabezados de columnas: Nombre de Alumno, Carrera Profesional, Periodo, Fecha de Registro.
      * [ ] Usar bucle foreach para pintar los registros recientes en filas.
    * [ ] Panel derecho: Canvas del Gráfico Estadístico:
      * [ ] Crear tarjeta para contener el gráfico de distribución por carrera.
      * [ ] Insertar etiqueta canvas con identificador único (id="dashboardCareersChart").
      * [ ] Diseñar el contenedor con altura fija para evitar desbordamientos del layout.



## Semana 3: 15 de Junio al 20 de Junio
* Horas semanales: 24
* Horas acumuladas: 72
* Entregables: Vistas del Módulo de Estudiantes: Listado de Estudiantes (students/index.blade.php) y Formulario de Registro (students/create.blade.php).

### Tareas y Actividades
* [ ] Diseño de la pantalla de listado de estudiantes (students/index.blade.php):
  * [ ] Extender de la plantilla base layouts.app y definir sección de contenido.
  * [ ] Estructurar la fila superior con el título de Estudiantes y el botón de registro.
  * [ ] Crear botón con enlace students.create de estilo btn-primary y con icono de adición.
  * [ ] Diseñar el panel de filtros y búsquedas mediante un formulario GET:
    * [ ] Campo de entrada de tipo texto para búsqueda por nombre, apellido o número de documento.
    * [ ] Menú de selección (select) para filtrar registros por carrera profesional.
    * [ ] Botón de envío del formulario para aplicar filtros activos.
    * [ ] Botón de limpieza para restaurar la vista completa sin filtros.
  * [ ] Estructurar la tabla de estudiantes con la clase table table-hover:
    * [ ] Cabeceras de tabla: Estudiante, Documento, Correo Electrónico, Carreras, Estado, Acciones.
    * [ ] Implementar directiva forelse de Laravel para recorrer estudiantes.
    * [ ] Mostrar nombre completo y detalles secundarios del alumno en la misma celda.
    * [ ] Mostrar número de documento nacional de identidad del alumno.
    * [ ] Mostrar la dirección de correo electrónico del estudiante.
    * [ ] Bucle interno para pintar múltiples insignias (badges) de carreras profesionales del alumno.
    * [ ] Configurar badges de color dinámico según el estado del estudiante:
      * [ ] Egresado: badge bg-info.
      * [ ] Titulado: badge bg-success.
      * [ ] Matriculado: badge bg-primary.
      * [ ] Retirado: badge bg-danger.
    * [ ] Columna de acciones: enlaces para visualizar (show), editar (edit) y formulario para eliminar.
    * [ ] Configurar formulario de eliminación con directiva @method('DELETE') y @csrf de seguridad.
    * [ ] Agregar función de confirmación nativa mediante JS onclick para evitar borrados accidentales.
    * [ ] Mostrar fila de alerta en caso de que no existan resultados registrados en la base de datos.
  * [ ] Renderizar los enlaces de paginación del listado mediante el método links() de Tailwind/Bootstrap.
* [ ] Diseño del formulario de creación de estudiantes (students/create.blade.php):
  * [ ] Diseñar contenedor centrado para el formulario con ancho máximo limitado.
  * [ ] Crear tarjeta de Bootstrap conteniendo el formulario de ingreso.
  * [ ] Definir formulario apuntando al método POST de la ruta students.store.
  * [ ] Insertar directiva de seguridad @csrf.
  * [ ] Campo de texto para Nombre Completo:
    * [ ] Aplicar la directiva @error('name') para inyectar la clase is-invalid de Bootstrap.
    * [ ] Agregar div invalid-feedback con el mensaje de error de validación de Laravel.
  * [ ] Campo de texto para Documento de Identidad:
    * [ ] Agregar validación visual y clase is-invalid en caso de fallas.
  * [ ] Campo de entrada para Correo Electrónico:
    * [ ] Configurar tipo de entrada email y agregar feedback de error correspondiente.
  * [ ] Campo de entrada para Teléfono de Contacto:
    * [ ] Configurar validación de caracteres numéricos.
  * [ ] Sección de selección de Carreras Profesionales:
    * [ ] Crear contenedor de tipo grid para organizar los checkboxes de carreras disponibles.
    * [ ] Recorrer las carreras activas y asignar el id al array names careers[].
    * [ ] Configurar la etiqueta label adecuada para cada checkbox.
  * [ ] Campo de selección para el Estado del estudiante:
    * [ ] Opciones: matriculado, egresado, retirado.
  * [ ] Campo selector de fecha para Fecha de Ingreso/Matrícula.
  * [ ] Botón de cancelación de color gris con enlace directo al listado de estudiantes.
  * [ ] Botón de guardado de datos con tipo submit y clase btn-primary.



## Semana 4: 22 de Junio al 27 de Junio
* Horas semanales: 24
* Horas acumuladas: 96
* Entregables: Vistas del Módulo de Estudiantes: Formulario de Edición (students/edit.blade.php) y Ficha de Detalle Académico (students/show.blade.php).

### Tareas y Actividades
* [ ] Diseño de la pantalla de edición de estudiantes (students/edit.blade.php):
  * [ ] Extender de layouts.app y definir sección content.
  * [ ] Crear contenedor de formulario de edición y tarjeta de Bootstrap.
  * [ ] Configurar formulario POST apuntando a la ruta students.update con el ID del estudiante.
  * [ ] Insertar la directiva de método PUT de Laravel (@method('PUT')).
  * [ ] Insertar la directiva de token CSRF (@csrf).
  * [ ] Campo de texto pre-rellenado para Nombre Completo utilizando old('name', $student->name).
  * [ ] Campo de texto pre-rellenado para Documento de Identidad del estudiante.
  * [ ] Campo de correo electrónico pre-rellenado y configurado con validaciones.
  * [ ] Campo de teléfono pre-rellenado y validado.
  * [ ] Contenedor para listado de checkboxes de carreras profesionales:
    * [ ] Verificar lógicamente si el estudiante está inscrito en la carrera para marcar el checkbox automáticamente mediante la directiva checked.
  * [ ] Selector pre-seleccionado con el estado actual del alumno.
  * [ ] Campo de fecha de matrícula pre-rellenada con la fecha de ingreso registrada en base de datos.
  * [ ] Botón para cancelar cambios y regresar al listado.
  * [ ] Botón para enviar cambios confirmados a la base de datos.
* [ ] Diseño de la vista de detalle y ficha académica del estudiante (students/show.blade.php):
  * [ ] Diseñar panel de cabecera con botón de regreso a la lista y botón de edición directa.
  * [ ] Dividir la interfaz en dos columnas responsivas: col-md-4 para el perfil y col-md-8 para el historial.
  * [ ] Ficha lateral izquierda de datos personales del estudiante:
    * [ ] Mostrar el nombre del alumno en formato destacado.
    * [ ] Mostrar número de documento de identidad del alumno.
    * [ ] Mostrar correo electrónico de contacto.
    * [ ] Mostrar teléfono de contacto.
    * [ ] Pintar la fecha de ingreso original registrada en el sistema.
    * [ ] Pintar la fecha de egreso si el estado del alumno es egresado o titulado.
    * [ ] Mostrar estado académico actual mediante badge de color grande.
  * [ ] Panel derecho de historial académico y carreras profesionales:
    * [ ] Crear tarjeta de Bootstrap para el listado de carreras en las que está matriculado.
    * [ ] Tabla de carreras detallando nombre, código y estado de cada programa de estudio.
    * [ ] Sección inferior con tabla que detalla el historial de matrículas por periodo académico.
    * [ ] Mostrar detalles de resoluciones o trámites de titulación si el alumno cuenta con ellos.



## Semana 5: 29 de Junio al 04 de Julio
* Horas semanales: 24
* Horas acumuladas: 120
* Entregables: Vistas del Módulo de Docentes: Listado de Docentes (teachers/index.blade.php) y Formulario de Creación/Edición (teachers/create.blade.php & teachers/edit.blade.php).

### Tareas y Actividades
* [ ] Diseño de la pantalla de listado de docentes (teachers/index.blade.php):
  * [ ] Diseñar cabecera con título de Docentes y botón de acceso al formulario de registro.
  * [ ] Crear botón con enlace a la ruta de registro de docentes y clases de estilo primary.
  * [ ] Diseñar formulario de búsqueda por filtros utilizando método GET:
    * [ ] Campo de entrada de texto para buscar por nombre del docente.
    * [ ] Campo de entrada de texto para buscar por especialidad académica.
    * [ ] Botón de envío de formulario para filtrar listado.
    * [ ] Botón de limpieza de filtros.
  * [ ] Estructurar la tabla de docentes de forma responsiva:
    * [ ] Encabezados: Docente, Documento, Correo Electrónico, Especialidad, Carreras Adscritas, Estado, Acciones.
    * [ ] Iterar docentes y pintar filas con datos.
    * [ ] Mostrar especialidad académica registrada del docente.
    * [ ] Recorrer e imprimir las carreras asociadas al docente mediante badges informativos.
    * [ ] Mostrar badge de estado (activo: verde, inactivo: rojo).
    * [ ] Columna de acciones: botón de visualización, edición y eliminación.
  * [ ] Agregar enlaces de paginación del listado.
* [ ] Diseño del formulario de creación y edición de docentes:
  * [ ] Crear contenedor y tarjeta de formulario para registrar docentes.
  * [ ] Formulario POST apuntando a la ruta de almacenamiento de docentes.
  * [ ] Insertar directiva CSRF.
  * [ ] Campo de texto para Nombre Completo del docente.
  * [ ] Campo de texto para Documento de Identidad del docente.
  * [ ] Campo de entrada para Correo Electrónico institucional del docente.
  * [ ] Campo de entrada para Teléfono de contacto.
  * [ ] Campo de entrada para Especialidad académica del docente.
  * [ ] Sección de checkboxes para asociar múltiples carreras profesionales al docente.
  * [ ] Selector para el estado de disponibilidad del docente (activo/inactivo).
  * [ ] Campo de fecha para la fecha de contratación.
  * [ ] Botón para cancelar cambios.
  * [ ] Botón para confirmar inserción de datos.
  * [ ] Reutilizar lógica de maquetación en la vista edit.blade.php aplicando la directiva PUT y rellenando los campos con datos existentes.



## Semana 6: 06 de Julio al 11 de Julio
* Horas semanales: 24
* Horas acumuladas: 144
* Entregables: Vistas del Módulo de Carreras: Listado (careers/index.blade.php) y Formularios de Registro (careers/create.blade.php & careers/edit.blade.php).

### Tareas y Actividades
* [ ] Diseño de la pantalla de listado de carreras profesionales (careers/index.blade.php):
  * [ ] Crear cabecera con botón de acceso al formulario de registro de carrera.
  * [ ] Formulario GET para búsquedas y filtrado de carreras por nombre y código.
  * [ ] Estructurar tabla responsiva de carreras:
    * [ ] Cabeceras de tabla: Código de Carrera, Nombre, Estado, Alumnos Matriculados, Docentes Adscritos, Acciones.
    * [ ] Iterar carreras y pintar datos correspondientes.
    * [ ] Mostrar código único identificador de carrera.
    * [ ] Mostrar nombre de la carrera profesional.
    * [ ] Mostrar badge de estado (activo/inactivo).
    * [ ] Pintar cantidad de alumnos y docentes asociados utilizando los métodos count() correspondientes.
    * [ ] Botones de edición y eliminación.
  * [ ] Renderizar enlaces de paginación del listado de carreras.
* [ ] Diseño del formulario de registro y edición de carreras:
  * [ ] Crear contenedor y tarjeta de formulario.
  * [ ] Formulario POST apuntando a la ruta de almacenamiento de carreras.
  * [ ] Directiva CSRF de seguridad.
  * [ ] Campo de texto para Código de Carrera (ej. INF, CIV, ADM).
  * [ ] Campo de texto para Nombre Completo de la carrera profesional.
  * [ ] Selector para definir el estado de la carrera profesional.
  * [ ] Botón de cancelación con enlace de regreso a la lista de carreras.
  * [ ] Botón de guardado submit de tipo primary.
  * [ ] Duplicar la estructura para la vista de edición de carreras incorporando la directiva de método PUT y pre-cargando los campos correspondientes.



## Semana 7: 13 de Julio al 18 de Julio
* Horas semanales: 24
* Horas acumuladas: 168
* Entregables: Vistas del Módulo de Matrículas Académicas: Listado General (enrollments/index.blade.php) y Formulario de Registro de Matrícula (enrollments/create.blade.php).

### Tareas y Actividades
* [ ] Diseño de la pantalla de listado de matrículas (enrollments/index.blade.php):
  * [ ] Estructurar cabecera con el título de Matrículas y botón para registrar matrícula.
  * [ ] Crear botón con enlace a la ruta enrollments.create.
  * [ ] Diseñar formulario GET para filtros del listado de matrículas:
    * [ ] Selector para buscar matrículas por Periodo Académico (academic_period_id).
    * [ ] Selector para filtrar matrículas por Carrera Profesional (career_id).
    * [ ] Botón para aplicar filtros.
    * [ ] Botón para limpiar filtros.
  * [ ] Estructurar la tabla de matrículas mediante clases responsive:
    * [ ] Cabeceras: ID Matrícula, Estudiante, Carrera, Periodo Académico, Fecha Matrícula, Estado, Acciones.
    * [ ] Iterar matrículas y pintar datos.
    * [ ] Mostrar nombre del estudiante matriculado.
    * [ ] Mostrar nombre de la carrera elegida.
    * [ ] Mostrar nombre del periodo académico correspondiente.
    * [ ] Mostrar fecha de matrícula formateada.
    * [ ] Mostrar badge de estado de matrícula (activo: verde, reserva: amarillo, retirado: rojo).
    * [ ] Botón de acción para dar de baja o editar la matrícula.
  * [ ] Mostrar mensaje informativo si no existen registros que coincidan con la búsqueda.
  * [ ] Renderizar paginador de registros.
* [ ] Diseño del formulario de registro de matrícula (enrollments/create.blade.php):
  * [ ] Crear contenedor centrado y tarjeta de formulario.
  * [ ] Formulario POST apuntando al método store del controlador de matrículas.
  * [ ] Directiva CSRF obligatoria.
  * [ ] Selector de Estudiante:
    * [ ] Cargar lista de alumnos en estado activo.
    * [ ] Directiva de error de Laravel para el campo.
  * [ ] Selector de Periodo Académico:
    * [ ] Cargar periodos creados en el sistema.
    * [ ] Directiva de error para el periodo académico.
  * [ ] Selector de Carrera Profesional:
    * [ ] Crear selector vacío para rellenar dinámicamente mediante Javascript.
    * [ ] Directiva de error para la carrera profesional.
  * [ ] Campo de fecha para enrollment_date.
  * [ ] Botón de retorno al listado general de matrículas.
  * [ ] Botón de guardado y registro definitivo.
* [ ] Implementación del script de carga dinámica AJAX para carreras de estudiantes:
  * [ ] Escribir script en sección scripts o push para interactuar con el selector de estudiante.
  * [ ] Añadir escucha de evento change al selector de estudiantes.
  * [ ] Realizar petición fetch a la ruta de la API que retorna las carreras asociadas al alumno seleccionado.
  * [ ] Limpiar las opciones previas del selector de carreras profesionales.
  * [ ] Rellenar el selector con las opciones recibidas en formato JSON.



## Semana 8: 20 de Julio al 25 de Julio
* Horas semanales: 24
* Horas acumuladas: 192
* Entregables: Vistas del Módulo de Graduados y Títulos: Panel de Egresados (degrees/index.blade.php) y Registro de Titulación (degrees/create.blade.php).

### Tareas y Actividades
* [ ] Diseño de la pantalla de listado de graduados y títulos (degrees/index.blade.php):
  * [ ] Estructurar cabecera con título de Egresados y Titulados y botón de obtención de grado.
  * [ ] Diseñar formulario de búsqueda GET:
    * [ ] Entrada de texto para búsqueda de alumnos egresados por nombre o documento.
    * [ ] Selector para filtrar por el estado de titulación (egresado, en trámite, titulado).
    * [ ] Botón de envío de filtros.
  * [ ] Estructurar la tabla de graduados y títulos:
    * [ ] Cabeceras: Graduado, Carrera Profesional, Estado de Grado, Resolución, Fecha Titulación, Acciones.
    * [ ] Iterar grados y pintar datos de registro.
    * [ ] Mostrar nombre completo del egresado.
    * [ ] Mostrar carrera profesional asociada.
    * [ ] Mostrar badge de estado (egresado: amarillo, en trámite: naranja, titulado: verde).
    * [ ] Mostrar el número de resolución administrativa.
    * [ ] Mostrar la fecha de titulación o de resolución.
    * [ ] Botón para editar o ver los datos del grado.
  * [ ] Paginación de registros.
* [ ] Diseño del formulario de registro de titulación (degrees/create.blade.php):
  * [ ] Crear contenedor centrado y tarjeta de Bootstrap.
  * [ ] Formulario POST apuntando al almacenamiento de grados.
  * [ ] Directiva CSRF obligatoria.
  * [ ] Selector de Estudiante Egresado:
    * [ ] Mostrar únicamente alumnos en estado de egreso apto.
    * [ ] Inyectar validación y mensajes de error correspondientes.
  * [ ] Selector de Carrera Profesional de la cual se gradúa.
  * [ ] Selector de Modalidad de Obtención del Título (tesis, examen de suficiencia, experiencia).
  * [ ] Campo de texto para número de resolución del título.
  * [ ] Campo de fecha para registrar la fecha exacta de expedición del título.
  * [ ] Botón de retorno al listado de egresados.
  * [ ] Botón de guardado y confirmación submit.



## Semana 9: 27 de Julio al 01 de Agosto
* Horas semanales: 24
* Horas acumuladas: 216
* Entregables: Vista de Detalle y Seguimiento del Expediente de Titulación con Línea de Tiempo (records/show.blade.php).

### Tareas y Actividades
* [ ] Diseño de la vista de detalle y seguimiento de expedientes (records/show.blade.php):
  * [ ] Crear cabecera con el código del expediente en fuente grande (ej. EXP-2026-0001) y botón de regreso.
  * [ ] Mostrar badge del estado actual del expediente.
  * [ ] Diseñar panel con datos generales del estudiante y su carrera profesional.
  * [ ] Diseño y maquetación de la línea de tiempo (timeline) horizontal del proceso:
    * [ ] Crear contenedor de la línea de tiempo con estilos personalizados de barra de progreso.
    * [ ] Nodo de estado "Registrado":
      * [ ] Aplicar clases CSS de completado y color verde si el estado es igual o posterior.
    * [ ] Nodo de estado "En Revisión":
      * [ ] Aplicar clases CSS condicionales basadas en el estado del expediente.
    * [ ] Nodo de estado "Subsanado":
      * [ ] Aplicar clases CSS condicionales.
    * [ ] Nodo de estado "Aprobado":
      * [ ] Aplicar clases CSS condicionales.
    * [ ] Nodo de estado "Apto para Sustentación":
      * [ ] Aplicar clases CSS de activo/pendiente correspondientes.
  * [ ] Bloque condicional para mostrar alerta de observaciones activas:
    * [ ] Pintar alerta con clases alert-warning si el estado actual del expediente tiene observaciones.
    * [ ] Mostrar el texto de la observación redactada por el evaluador académico.
  * [ ] Estructurar la tabla de documentos adjuntos al expediente:
    * [ ] Cabeceras: Tipo de Documento, Archivo, Versión, Fecha de Carga, Descarga.
    * [ ] Bucle para recorrer documentos asociados.
    * [ ] Mostrar nombre del tipo de documento (certificado, borrador de tesis, resolución).
    * [ ] Mostrar la versión del archivo (v1, v2).
    * [ ] Botón para descargar el documento adjunto de forma directa.
  * [ ] Diseñar el formulario de cambio de estado para evaluadores y coordinadores:
    * [ ] Controlar visibilidad del formulario según el rol del usuario autenticado.
    * [ ] Selector de nuevos estados válidos para el expediente.
    * [ ] Área de texto (textarea) para redactar observaciones de cambio de estado.
    * [ ] Botón de guardado y actualización del estado del expediente.



## Semana 10: 03 de Agosto al 08 de Agosto
* Horas semanales: 24
* Horas acumuladas: 240
* Entregables: Dashboard del Asesor de Proyectos (advisor/dashboard.blade.php) y Vistas de Gestión de Jurados (jurors/index.blade.php).

### Tareas y Actividades
* [ ] Diseño del Dashboard de Proyectos Asignados al Asesor (advisor/dashboard.blade.php):
  * [ ] Estructurar cabecera con el título de Proyectos de Tesis Asignados.
  * [ ] Diseñar caja resumen superior con el conteo de proyectos en estado activo.
  * [ ] Estructurar tabla de proyectos a cargo del docente asesor:
    * [ ] Columnas: Tesista, Título de Tesis, Fecha de Asignación, Estado de Proyecto, Acciones.
    * [ ] Recorrer proyectos del asesor.
    * [ ] Mostrar nombre del estudiante tesista.
    * [ ] Mostrar título de la tesis de investigación.
    * [ ] Mostrar fecha de asignación del rol de asesor.
    * [ ] Mostrar badge de estado de proyecto (propuesto: azul, aprobado: verde, rechazado: rojo, culminado: gris).
    * [ ] Botón para abrir modal de revisión y observaciones de la tesis.
  * [ ] Implementar el modal de revisión de avances de tesis:
    * [ ] Título del modal con detalles del proyecto de tesis.
    * [ ] Área de texto para ingresar las observaciones del asesor.
    * [ ] Formulario con envío POST para guardar la retroalimentación del asesor.
  * [ ] Mostrar mensaje informativo si el asesor no cuenta con proyectos a su cargo.
* [ ] Diseño de la pantalla de administración de jurados aptos (jurors/index.blade.php):
  * [ ] Estructurar cabecera de sección de jurados de sustentación.
  * [ ] Diseñar grilla y tabla de docentes habilitados como jurados en la institución:
    * [ ] Cabeceras: Docente, Especialidad, Estado de Habilitación, Acciones.
    * [ ] Iterar registros de jurados en base de datos.
    * [ ] Mostrar nombre y departamento académico del docente.
    * [ ] Mostrar especialidad académica.
    * [ ] Mostrar badge de estado de disponibilidad (activo: verde, inactivo: rojo).
    * [ ] Botón de tipo switch o toggle en formulario para cambiar estado de disponibilidad.
    * [ ] Configurar envío POST para habilitar/inhabilitar docentes en el rol de jurado.



## Semana 11: 10 de Agosto al 15 de Agosto
* Horas semanales: 24
* Horas acumuladas: 264
* Entregables: Vistas del Módulo de Sustentaciones: Calendario de Sustentaciones (defenses/index.blade.php) y Acta de Calificación (defenses/show.blade.php).

### Tareas y Actividades
* [ ] Diseño de la pantalla de programación y listado de sustentaciones (defenses/index.blade.php):
  * [ ] Estructurar cabecera con título de Sustentaciones Programadas y botón para agendar.
  * [ ] Crear botón para abrir el formulario de agendamiento.
  * [ ] Diseñar tabla de sustentaciones programadas:
    * [ ] Cabeceras: Proyecto de Tesis, Estudiante, Fecha y Hora, Local/Aula, Jurados Asignados, Estado, Acciones.
    * [ ] Iterar sustentaciones y rellenar filas de la tabla.
    * [ ] Mostrar título del proyecto sustentado.
    * [ ] Mostrar nombre completo del estudiante.
    * [ ] Mostrar fecha y hora en formato entendible (d/m/Y H:i).
    * [ ] Mostrar el aula física reservada para la sustentación.
    * [ ] Lista compacta de los tres jurados asignados (Presidente, Secretario, Vocal).
    * [ ] Mostrar badge de estado (programado: azul, realizado: verde, suspendido/reprogramado: rojo).
    * [ ] Enlace para acceder al acta de sustentación y calificación.
* [ ] Diseño de la vista de Acta de Sustentación y Calificación (defenses/show.blade.php):
  * [ ] Diseñar el panel de visualización simulando el formato físico del acta académica.
  * [ ] Mostrar encabezado formal con número correlativo único de acta (ej. ACTA-2026-0001).
  * [ ] Detallar datos generales: Estudiante, Título del Proyecto, Carrera Profesional, Fecha y Hora del evento.
  * [ ] Detallar la terna de jurados asistentes y sus respectivos cargos asignados.
  * [ ] Diseñar la sección de ingreso de calificaciones para la sustentación:
    * [ ] Caja de texto para ingresar la calificación promedio final (grade) con decimales.
    * [ ] Selector para el estado de resultado (aprobado con distinción, aprobado, desaprobado).
    * [ ] Área para firmas simbólicas del jurado evaluador.
  * [ ] Formulario POST para guardar los resultados de la sustentación y generar el acta.
  * [ ] Botón de descarga de acta formal en PDF.



## Semana 12: 17 de Agosto al 22 de Agosto
* Horas semanales: 24
* Horas acumuladas: 288
* Entregables: Vistas del Módulo de Reportes Estadísticos: Alertas de Deserción Escolar (reports/dropout.blade.php) e Indicadores Gráficos de Titulación (reports/degrees.blade.php).

### Tareas y Actividades
* [ ] Diseño de la vista de alertas de deserción escolar (reports/dropout.blade.php):
  * [ ] Cabecera de sección con el título de Alertas de Deserción Escolar.
  * [ ] Caja de alerta descriptiva explicando las reglas del algoritmo de detección de no continuantes.
  * [ ] Formulario GET con selector de Periodo Académico a analizar.
  * [ ] Botón de envío de formulario para ejecutar el cálculo.
  * [ ] Estructurar la tabla de estudiantes no continuantes:
    * [ ] Cabeceras: Estudiante, Documento, Carrera, Último Ciclo Matriculado, Acciones.
    * [ ] Iterar resultados de alertas e imprimir filas.
    * [ ] Mostrar nombre y datos del estudiante en riesgo de deserción.
    * [ ] Mostrar último periodo académico en el que registró matrícula.
    * [ ] Botón de acción para enviar correo de seguimiento y alerta institucional.
  * [ ] Mensaje de aviso en caso de no registrarse estudiantes no continuantes en el periodo.
* [ ] Diseño del panel de indicadores gráficos de titulación (reports/degrees.blade.php):
  * [ ] Cabecera de sección con título de Reportes Estadísticos de Titulación.
  * [ ] Diseñar grilla row con dos columnas de igual tamaño para gráficos.
  * [ ] Tarjeta izquierda para gráfico de tasa de graduados por carrera profesional:
    * [ ] Estructurar tarjeta de Bootstrap con cabecera minimalista.
    * [ ] Insertar etiqueta canvas con id="gradsByCareerChart".
  * [ ] Tarjeta derecha para gráfico de modalidades de titulación:
    * [ ] Estructurar tarjeta de Bootstrap.
    * [ ] Insertar etiqueta canvas con id="degreeModalitiesChart".
  * [ ] Implementación de scripts de inicialización de Chart.js:
    * [ ] Enlazar script de CDN de Chart.js en la parte inferior o a través del asset compiler.
    * [ ] Añadir sección script con escucha del evento DOMContentLoaded.
    * [ ] Inicializar gráfico de barras para tasa de graduados:
      * [ ] Obtener contexto 2D del canvas gradsByCareerChart.
      * [ ] Configurar etiquetas (labels) obtenidas dinámicamente desde el backend.
      * [ ] Definir dataset con valores de porcentaje de graduados.
      * [ ] Configurar colores de barras y bordes.
    * [ ] Inicializar gráfico de tipo dona (doughnut) para modalidades de titulación:
      * [ ] Obtener contexto 2D del canvas degreeModalitiesChart.
      * [ ] Configurar etiquetas para las modalidades de titulación (tesis, examen, experiencia).
      * [ ] Configurar datos de distribución.
      * [ ] Definir colores de los sectores del gráfico de dona.



## Semana 13: 24 de Agosto al 25 de Agosto
* Horas semanales: 2
* Horas acumuladas: 290
* Entregables: Ajustes Finales de Responsive, Validación Cruzada de CSS y Pruebas de Usabilidad UI.

### Tareas y Actividades
* [ ] Ajustes finales de interfaz y maquetación responsive:
  * [ ] Validar visualización correcta de menús y barras laterales en pantallas móviles pequeñas.
  * [ ] Revisar comportamiento de tablas con scroll horizontal en pantallas táctiles de poco ancho.
  * [ ] Probar el tamaño y legibilidad de fuentes tipográficas en diferentes pantallas.
  * [ ] Verificar contrastes y alineaciones de las alertas flash de sesión del usuario.
  * [ ] Corregir espaciados y paddings en modales de jurados y asesores.
  * [ ] Asegurar compatibilidad de estilos e inyección de gráficos interactivos Chart.js.
  * [ ] Limpiar código innecesario y comentar de forma descriptiva el archivo de estilos index.css.
