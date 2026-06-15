# Checklist de Avance Detallado - CESAR (Gestión de Procesos y Negocio)

Este documento contiene la hoja de ruta, especificaciones de procesos académicos, máquinas de estado y tareas de desarrollo backend/procesos para el programador CESAR, encargado de la gestión de expedientes, proyectos de investigación, tutorías, sustentaciones y gestión documental.

* Duración total asignada: 290 horas (4 horas diarias, 6 días a la semana, excepto la última semana de 2 horas)
* Tecnología: Laravel 12, PHP 8.x, MariaDB



## Semana 1: 01 de Junio al 06 de Junio
* Horas semanales: 24
* Horas acumuladas: 24
* Entregables: Casos de Uso Multi-Carrera y Reglas de Negocio Iniciales.

### Tareas y Actividades
* [X] Diseñar el mapa de procesos de titulación general de forma conceptual y detallada:
  * [X] Definir el flujograma de procesos desde el registro del estudiante hasta la obtención del grado.
  * [X] Establecer las dependencias lógicas entre los diferentes módulos del sistema (SAM).
* [X] Especificar los requisitos mínimos documentales para egresados de cada carrera profesional de la universidad:
  * [X] Requisitos documentales específicos para la carrera de Ingeniería de Sistemas.
  * [X] Requisitos documentales específicos para la carrera de Ingeniería Civil.
  * [X] Requisitos documentales específicos para la carrera de Administración de Empresas.
  * [X] Requisitos documentales específicos para la carrera de Derecho y Ciencias Políticas.
* [X] Validar el flujo de datos del estudiante en múltiples programas de estudio concurrentes:
  * [X] Definir reglas para estudiantes matriculados en dos carreras en paralelo.
  * [X] Especificar cómo se separa el historial académico de cada carrera en el backend.
* [X] Documentar los flujos de transición de estados del expediente de titulación a nivel de reglas de negocio:
  * [X] Definir los estados válidos del expediente (registrado, en revisión, subsanado, aprobado, apto).
  * [X] Mapear las transiciones permitidas e identificar las transiciones prohibidas.
* [X] Elaborar los requerimientos funcionales detallados para el registro de estudiantes en la base de datos:
  * [X] Definir campos requeridos y opcionales para la ficha del estudiante.
* [X] Elaborar los requerimientos funcionales detallados para el registro de docentes en la base de datos:
  * [X] Definir campos requeridos, especialidades y restricciones por departamento académico.
* [X] Definir los campos obligatorios para las tablas de enlace de carreras en formato de diccionario de datos conceptual:
  * [X] Detallar la estructura y llaves foráneas de la tabla pivote de carreras y estudiantes.
  * [X] Detallar la estructura y llaves foráneas de la tabla pivote de docentes y carreras.
* [ ] Detallar los Casos de Uso del core relacional del sistema:
  * [ ] Caso de Uso: Registrar Estudiante en la Plataforma
  * [ ] Caso de Uso: Listar Estudiantes con Filtros Académicos
  * [ ] Caso de Uso: Visualizar Ficha de Estudiante con Historial
  * [ ] Caso de Uso: Actualizar Datos de Estudiante y Carreras
  * [ ] Caso de Uso: Eliminar Estudiante (Baja Lógica / Física)
  * [ ] Caso de Uso: Registrar Docente en la Plataforma
  * [ ] Caso de Uso: Listar Docentes por Carrera Profesional
  * [ ] Caso de Uso: Modificar Especialidad Docente y Estado
  * [ ] Caso de Uso: Dar de Baja Docente Administrativamente
  * [ ] Caso de Uso: Registrar Carrera Profesional
  * [ ] Caso de Uso: Modificar Código o Nombre de Carrera
  * [ ] Caso de Uso: Activar/Inactivar Carrera Profesional
  * [ ] Caso de Uso: Asignar Estudiante a Carrera Profesional
  * [ ] Caso de Uso: Asignar Docente a Carrera Profesional



## Semana 2: 08 de Junio al 13 de Junio
* Horas semanales: 24
* Horas acumuladas: 48
* Entregables: Casos de Uso de Seguridad, Autenticación y Dashboard Administrativo.

### Tareas y Actividades
* [ ] Definir las políticas de seguridad para el acceso al panel principal por parte de coordinadores y alumnos:
  * [ ] Especificar reglas para el manejo de sesiones concurrentes de un mismo usuario.
  * [ ] Definir el tiempo de expiración de sesión por inactividad del usuario (120 minutos).
* [ ] Especificar los niveles de acceso por rol dentro del sistema de titulación:
  * [ ] Definir permisos y acciones permitidas para el Administrador del Sistema.
  * [ ] Definir permisos y acciones permitidas para el Coordinador Académico.
  * [ ] Definir permisos y acciones permitidas para el Docente Evaluador/Jurado.
  * [ ] Definir permisos y acciones permitidas para el Estudiante Tesista.
* [ ] Diseñar el flujo funcional de recuperación de claves y reconfirmación de seguridad para cambios de datos:
  * [ ] Detallar pasos del flujo de restablecimiento de contraseña mediante enlace de correo.
  * [ ] Definir regla para requerir confirmación de contraseña vieja en actualizaciones críticas.
* [ ] Validar los campos de auditoría para el inicio de sesión y bloqueos de cuenta de usuarios:
  * [ ] Registrar el número de intentos fallidos antes de bloquear una cuenta (máximo 5).
  * [ ] Especificar los campos de la bitácora de auditoría de accesos.
* [ ] Definir los indicadores y métricas clave para mostrar en el Dashboard del sistema de titulación:
  * [ ] Indicador clave: Cantidad de estudiantes matriculados en el periodo actual.
  * [ ] Indicador clave: Cantidad de egresados totales registrados.
  * [ ] Indicador clave: Cantidad de expedientes en estado de revisión.
  * [ ] Indicador clave: Alertas de estudiantes identificados en deserción escolar.
* [ ] Mapear las fuentes de datos para el cálculo de estadísticas de matrículas activas:
  * [ ] Definir las relaciones necesarias para calcular matrículas por carrera y periodo académico.
* [ ] Documentar el comportamiento de las alertas flash ante fallos de inicio de sesión o caducidad de tokens de sesión:
  * [ ] Diseñar mensajes descriptivos de error para el usuario final ante excepciones.
* [ ] Detallar los Casos de Uso para el acceso y panel central del sistema:
  * [ ] Caso de Uso: Iniciar Sesión en la Plataforma
  * [ ] Caso de Uso: Cerrar Sesión del Usuario Autenticado
  * [ ] Caso de Uso: Solicitar Restablecimiento de Contraseña
  * [ ] Caso de Uso: Confirmar Cambio de Contraseña mediante Email
  * [ ] Caso de Uso: Bloquear Cuenta de Usuario tras Intentos Fallidos
  * [ ] Caso de Uso: Auditar Accesos Fallidos a la Plataforma
  * [ ] Caso de Uso: Visualizar Panel Principal (Dashboard) Administrativo
  * [ ] Caso de Uso: Visualizar Métricas en el Dashboard del Coordinador
  * [ ] Caso de Uso: Visualizar Alertas de Deserción en el Dashboard



## Semana 3: 15 de Junio al 20 de Junio
* Horas semanales: 24
* Horas acumuladas: 72
* Entregables: Reglas de Negocio para el Módulo Core de Estudiantes y Docentes.

### Tareas y Actividades
* [ ] Especificar las validaciones de campos del estudiante:
  * [ ] Validar que el formato de documento nacional de identidad sea numérico y de longitud correcta.
  * [ ] Validar que el DNI contenga exactamente 8 dígitos numéricos sin letras.
  * [ ] Validar que para pasaportes extranjeros se acepten caracteres alfanuméricos hasta 12 dígitos.
  * [ ] Validar el formato y dominio de las direcciones de correo electrónico registradas.
  * [ ] Validar que las direcciones de correo institucional terminen con el dominio oficial de la universidad.
  * [ ] Validar que no se permitan correos electrónicos duplicados entre distintos estudiantes.
  * [ ] Validar formato de números de teléfono celular para notificaciones SMS del sistema.
  * [ ] Validar que los números telefónicos ingresados comiencen opcionalmente con el prefijo de país.
* [ ] Definir la lógica de validación para la asociación de múltiples carreras simultáneas a un mismo alumno:
  * [ ] Impedir asociar la misma carrera profesional más de una vez a un estudiante en la tabla pivote.
  * [ ] Validar que el estudiante no supere el límite máximo de tres carreras profesionales matriculadas simultáneamente.
* [ ] Determinar las reglas de borrado lógico (soft deletes) para evitar pérdida de registros históricos en base de datos:
  * [ ] Especificar tablas que requieren borrado lógico (students, teachers, careers).
  * [ ] Definir qué ocurre con los expedientes asociados si se da de baja lógica a un estudiante.
  * [ ] Registrar el usuario responsable y la fecha exacta del borrado lógico en logs de auditoría.
* [ ] Diseñar los campos de especialización de los docentes y sus restricciones por facultad:
  * [ ] Definir especialidades docentes válidas asociadas a las carreras registradas en el sistema.
  * [ ] Restringir las asignaciones de jurados según la concordancia entre especialidad docente y tema de tesis.
* [ ] Definir el comportamiento del sistema al intentar dar de baja a un docente con tesis activas a su cargo:
  * [ ] Impedir la desactivación o borrado de un docente si figura como asesor activo en algún proyecto.
  * [ ] Programar alerta de reasignación obligatoria de asesor antes de dar la baja docente.
  * [ ] Bloquear la inhabilitación del docente si tiene asignaciones pendientes de sustentación como jurado.
* [ ] Validar los formatos de fecha para la contratación e inicio de actividades de profesores:
  * [ ] Validar que la fecha de contratación no sea posterior a la fecha actual del servidor.
  * [ ] Validar que la fecha de contratación sea posterior por al menos 18 años a la fecha de nacimiento del docente.



## Semana 4: 22 de Junio al 27 de Junio
* Horas semanales: 24
* Horas acumuladas: 96
* Entregables: Reglas de Negocio para el Módulo de Carreras Profesionales.

### Tareas y Actividades
* [ ] Especificar las restricciones del código identificador único de carrera en la base de datos:
  * [ ] Validar que la abreviatura de carrera (code) tenga un formato alfanumérico de 3 a 5 caracteres.
  * [ ] Asegurar que el código de la carrera sea convertido a mayúsculas de forma automática antes de persistir.
  * [ ] Validar que no existan espacios en blanco en el código identificador único.
* [ ] Definir la lógica de activación e inactivación de carreras y sus repercusiones en estudiantes matriculados activos:
  * [ ] Impedir la inactivación de una carrera profesional si cuenta con matrículas activas en el periodo vigente.
  * [ ] Bloquear la inactivación si la carrera tiene expedientes de titulación abiertos sin culminar.
* [ ] Documentar los flujos de re-asignación de estudiantes cuando una carrera es dada de baja administrativamente:
  * [ ] Definir pasos funcionales para transferir alumnos a otros programas de estudio disponibles.
  * [ ] Validar la convalidación automática de cursos comunes al realizar la transferencia.
* [ ] Validar las estructuras de datos de la escuela profesional para la generación de reportes ministeriales oficiales:
  * [ ] Detallar campos requeridos para la exportación de reportes de graduados a la superintendencia de educación.
  * [ ] Validar longitud y formato de los códigos de carrera autorizados por el ministerio.




## Semana 5: 29 de Junio al 04 de Julio
* Horas semanales: 24
* Horas acumuladas: 120
* Entregables: Reglas de Negocio y Estructura Funcional para Gestión de Matrículas por Periodo.

### Tareas y Actividades
* [ ] Definir los campos obligatorios del Periodo Académico (AcademicPeriod):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo name (string, max: 50, unique index, not null).
  * [ ] Campo start_date (date, not null).
  * [ ] Campo end_date (date, not null).
  * [ ] Campo status (enum: activo, inactivo).
  * [ ] Validar que la fecha de inicio (start_date) sea anterior a la fecha de término (end_date).
  * [ ] Validar que no existan traslapes de fechas entre dos periodos declarados activos de forma concurrente.
  * [ ] Asegurar que el formato de nombre del periodo académico siga la nomenclatura oficial (ej. YYYY-I, YYYY-II).
* [ ] Definir los campos obligatorios de la Matrícula (Enrollment):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo student_id (bigint, foreign key, not null).
  * [ ] Campo career_id (bigint, foreign key, not null).
  * [ ] Campo academic_period_id (bigint, foreign key, not null).
  * [ ] Campo enrollment_date (date, not null).
  * [ ] Campo status (enum: activo, reserva, retirado).
  * [ ] Validar que el estudiante seleccionado tenga un estado de registro activo antes de permitir su matrícula.
  * [ ] Validar que el estudiante pertenezca efectivamente a la carrera seleccionada.
* [ ] Especificar las reglas de control para impedir matrículas concurrentes duplicadas en el mismo periodo lectivo:
  * [ ] Impedir registrar matrícula de un alumno en la misma carrera y el mismo ciclo académico dos veces.
  * [ ] Impedir registrar matrícula en caso de que el estudiante ya cuente con un egreso registrado en esa carrera.
* [ ] Validar la consistencia de la fecha de matrícula respecto al rango del periodo académico activo en el sistema:
  * [ ] Validar que la fecha de matrícula se encuentre dentro de las fechas de inicio y fin del ciclo activo.
  * [ ] Permitir excepciones únicamente para matrículas de tipo extemporáneo autorizadas por resolución de decanato.
* [ ] Detallar los Casos de Uso del módulo de matrículas:
  * [ ] Caso de Uso: Crear Periodo Académico
  * [ ] Caso de Uso: Listar Periodos Académicos
  * [ ] Caso de Uso: Modificar Periodo Académico y Estado
  * [ ] Caso de Uso: Eliminar Periodo Académico sin Matrículas
  * [ ] Caso de Uso: Registrar Matrícula de Estudiante
  * [ ] Caso de Uso: Cambiar Estado de Matrícula (Reserva / Retirado)
  * [ ] Caso de Uso: Consultar Historial de Matrículas por Alumno
  * [ ] Caso de Uso: Exportar Reporte de Matrículas del Periodo
  * [ ] Caso de Uso: Registrar Reserva de Matrícula Especial
  * [ ] Caso de Uso: Registrar Retiro Voluntario de Matrícula en el Ciclo




## Semana 6: 06 de Julio al 11 de Julio
* Horas semanales: 24
* Horas acumuladas: 144
* Entregables: Reglas de Negocio de Graduaciones, Egreso y Obtención del Título.

### Tareas y Actividades
* [ ] Definir los campos obligatorios de la Titulación (Degree):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo student_id (bigint, foreign key, not null).
  * [ ] Campo career_id (bigint, foreign key, not null).
  * [ ] Campo status (enum: egresado, en_tramite, titulado).
  * [ ] Campo metodo_titulacion (enum: tesis, examen_suficiencia, experiencia_laboral, nullable).
  * [ ] Campo fecha_titulacion (date, nullable).
  * [ ] Campo numero_resolucion (string, max: 255, nullable).
  * [ ] Validar que el estudiante no cuente con un registro de grado previo para la misma carrera.
  * [ ] Validar que la fecha de egreso esté ingresada en la ficha del estudiante antes de otorgar el grado.
  * [ ] Validar que el metodo_titulacion sea obligatorio si el estado es titulado o en_tramite.
* [ ] Especificar la lógica de bloqueo de matrícula cuando un estudiante adquiere la condición de titulado:
  * [ ] Impedir de forma automatizada nuevas matrículas a estudiantes titulados en la carrera de la cual se gradúan.
  * [ ] Permitir matrícula en otras carreras profesionales distintas si el estudiante sigue un programa paralelo.
* [ ] Validar la coherencia de la fecha de resolución respecto a la fecha de egreso del alumno registrado:
  * [ ] La fecha de resolución del título debe ser posterior o igual a la fecha de egreso del estudiante.
  * [ ] Validar que la fecha de resolución no sea posterior a la fecha actual del servidor.
* [ ] Detallar los Casos de Uso del módulo de graduación:
  * [ ] Caso de Uso: Registrar Obtención de Grado y Título
  * [ ] Caso de Uso: Consultar Egresados y Titulados por Carrera
  * [ ] Caso de Uso: Modificar Datos de Resolución Administrativa
  * [ ] Caso de Uso: Anular Registro de Grado por Error de Transacción
  * [ ] Caso de Uso: Cambiar Estado de Estudiante a Egresado tras Cumplir Créditos
  * [ ] Caso de Uso: Registrar Fecha de Egreso Oficial del Alumno



## Semana 7: 13 de Julio al 18 de Julio
* Horas semanales: 24
* Horas acumuladas: 168
* Entregables: Lógica del Módulo de Expedientes de Titulación e Historial de Estados.

### Tareas y Actividades
* [ ] Especificar la estructura detallada de la tabla de Expedientes (records):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo student_id (bigint, foreign key, not null).
  * [ ] Campo career_id (bigint, foreign key, not null).
  * [ ] Campo code (string, unique, not null).
  * [ ] Campo current_status (enum: registrado, en_revision, subsanado, aprobado, apto_sustentacion).
  * [ ] Campo initiated_date (date, not null).
  * [ ] Validar que el código del expediente siga el patrón EXP-YYYY-CORRELATIVO.
  * [ ] Validar que no se abran dos expedientes de titulación activos para el mismo estudiante en la misma carrera.
* [ ] Especificar la estructura detallada de la tabla de Historial (record_histories):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo record_id (bigint, foreign key, not null).
  * [ ] Campo previous_status (string, nullable).
  * [ ] Campo new_status (string, not null).
  * [ ] Campo observation (text, nullable).
  * [ ] Campo user_id (bigint, foreign key, not null).
  * [ ] Validar que el user_id registrado en el historial corresponda al evaluador académico autenticado.
* [ ] Definir los métodos del controlador RecordController.php a nivel de procesos:
  * [ ] Método index(): Filtrado por estado de expediente.
  * [ ] Método store(): Generar código secuencial automático (EXP-YYYY-CORRELATIVO).
  * [ ] Método show(): Relaciones y línea de tiempo de auditoría.
  * [ ] Método updateStatus(): Cambiar estado e insertar en la bitácora de auditoría histórica.
* [ ] Validar la máquina de estados del expediente impidiendo saltos de estado no permitidos:
  * [ ] Impedir transición directa de registrado a aprobado sin haber pasado por el estado de revisión.
  * [ ] Validar que las observaciones no estén vacías si el expediente pasa a subsanación o rechazo.
* [ ] Detallar los Casos de Uso para el módulo de expedientes:

  * [ ] Caso de Uso: Iniciar Expediente de Titulación
  * [ ] Caso de Uso: Listar Expedientes de Titulación con Filtros
  * [ ] Caso de Uso: Visualizar Detalle y Línea de Tiempo de Expediente
  * [ ] Caso de Uso: Registrar Observaciones al Expediente en Revisión
  * [ ] Caso de Uso: Modificar Estado del Expediente a Subsanado
  * [ ] Caso de Uso: Registrar Aprobación del Expediente Académico
  * [ ] Caso de Uso: Declarar Expediente Apto para Sustentación
  * [ ] Caso de Uso: Consultar Historial y Bitácora del Expediente



## Semana 8: 20 de Julio al 25 de Julio
* Horas semanales: 24
* Horas acumuladas: 192
* Entregables: Reglas de Negocio para la Habilitación y Asignación de Jurados.

### Tareas y Actividades
* [ ] Definir la estructura de la tabla de jurados (jurors) a nivel de negocio:
  * [ ] Campo id (bigint, primary key).
  * [ ] Campo teacher_id (bigint, foreign key, unique).
  * [ ] Campo status (enum: activo, inactivo).
  * [ ] Validar que el docente exista y se encuentre en estado activo en la tabla de docentes antes de permitir su habilitación.
* [ ] Definir la estructura de la tabla de asignación de jurados (jury_assignments):
  * [ ] Campo id (bigint, primary key).
  * [ ] Campo defense_id (bigint, foreign key).
  * [ ] Campo juror_id (bigint, foreign key).
  * [ ] Campo role (enum: presidente, secretario, vocal).
  * [ ] Validar que un docente asignado como jurado no sea el asesor principal (tutor) del estudiante sustentante.
  * [ ] Validar que los tres jurados asignados a una misma sustentación correspondan a docentes distintos.
  * [ ] Validar que los roles de presidente, secretario y vocal se distribuyan sin duplicados en la terna.
* [ ] Especificar las reglas de asignación de cargos (presidente, secretario, vocal) según la antigüedad o categoría docente:
  * [ ] El docente con mayor categoría o antigüedad dentro de la terna debe asumir el rol de Presidente.
* [ ] Detallar los Casos de Uso del módulo de jurados:
  * [ ] Caso de Uso: Habilitar Docente como Jurado de Sustentación
  * [ ] Caso de Uso: Listar Docentes Jurados por Especialidad
  * [ ] Caso de Uso: Inhabilitar Docente del Rol de Jurado
  * [ ] Caso de Uso: Asignar Jurados a una Sustentación (Terna Completa)
  * [ ] Caso de Uso: Modificar Composición de la Terna de Jurados
  * [ ] Caso de Uso: Validar Conflictos de Interés en la Asignación de Jurados




## Semana 9: 27 de Julio al 01 de Agosto
* Horas semanales: 24
* Horas acumuladas: 216
* Entregables: Módulo de Proyectos de Tesis y Reglas de Asignación de Asesores.

### Tareas y Actividades
* [ ] Definir la estructura de la tabla de Proyectos (projects):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo student_id (bigint, foreign key, not null).
  * [ ] Campo title (string, max: 500, not null).
  * [ ] Campo description (text, not null).
  * [ ] Campo status (enum: propuesto, aprobado, rechazado, culminado).
  * [ ] Validar que el estudiante pertenezca a la carrera profesional del proyecto.
  * [ ] Validar que el título sea único para evitar proyectos idénticos en la misma escuela.
  * [ ] Validar que el título tenga un mínimo de 20 caracteres y un máximo de 500.
  * [ ] Validar que el resumen o descripción del proyecto contenga al menos 100 caracteres.
* [ ] Definir la estructura de la tabla de Asignación de Asesores (advisor_assignments):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo project_id (bigint, foreign key, not null).
  * [ ] Campo teacher_id (bigint, foreign key, not null).
  * [ ] Campo assignment_date (date, not null).
  * [ ] Campo status (enum: activo, inactivo).
  * [ ] Validar que el docente asignado tenga un estado de disponibilidad activo.
  * [ ] Validar que el docente y el estudiante no sean la misma persona.
  * [ ] Validar que la fecha de asignación no sea anterior a la fecha de creación del proyecto.
* [ ] Implementar la regla de límite máximo de asesorados (máximo 5 proyectos activos por docente):
  * [ ] Denegar asignación si el conteo de proyectos activos del docente seleccionado es igual a 5.
* [ ] Validar que la carrera profesional del proyecto del estudiante coincida con el departamento de adscripción del profesor asesor:
  * [ ] Verificar concordancia de carrera antes de permitir la tutoría.
* [ ] Escribir la lógica para inactivar automáticamente al asesor previo en caso de cambio de tutor:
  * [ ] Actualizar el estado del asesor anterior a inactivo al momento de registrar el nuevo asesor activo.
* [ ] Detallar los Casos de Uso del módulo de proyectos y asesorías:
  * [ ] Caso de Uso: Registrar Proyecto de Investigación / Tesis
  * [ ] Caso de Uso: Modificar Título o Resumen de Proyecto de Tesis
  * [ ] Caso de Uso: Cambiar Estado del Proyecto de Tesis
  * [ ] Caso de Uso: Asignar Docente Asesor a Proyecto de Tesis
  * [ ] Caso de Uso: Cambiar Docente Asesor del Proyecto de Tesis
  * [ ] Caso de Uso: Consultar Proyectos de Tesis a Cargo del Asesor
  * [ ] Caso de Uso: Registrar Historial de Cambios de Asesor del Proyecto
  * [ ] Caso de Uso: Consultar Capacidad Disponible de un Docente para Asesorar




## Semana 10: 03 de Agosto al 08 de Agosto
* Horas semanales: 24
* Horas acumuladas: 240
* Entregables: Gestión de Sustentaciones, Calificaciones y Actas Correlativas.

### Tareas y Actividades
* [ ] Definir la estructura de la tabla de Sustentaciones (defenses):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo project_id (bigint, foreign key, not null).
  * [ ] Campo defense_date (datetime, not null).
  * [ ] Campo location (string, not null).
  * [ ] Campo grade (decimal, precision: 4, scale: 2, nullable).
  * [ ] Campo status (enum: programado, realizado, reprogramado).
  * [ ] Campo act_number (string, unique, nullable).
  * [ ] Validar que la nota (grade) se encuentre estrictamente entre los valores 0.00 y 20.00.
  * [ ] Validar que el número de acta siga el formato correlativo ACTA-YYYY-CORRELATIVO.
* [ ] Desarrollar lógica en el controlador de sustentaciones (DefenseController.php) a nivel funcional:
  * [ ] Método store(): Reservar fecha de sustentación validando disponibilidad.
  * [ ] Validar que no exista cruce de horarios para el local o aula física seleccionada (margen de 2 horas).
  * [ ] Validar que ninguno de los tres jurados asignados tenga otra sustentación en el mismo rango de fecha y hora.
  * [ ] Programar notificaciones automáticas por correo a los jurados y al estudiante al programar la sustentación.
  * [ ] Validar que la fecha y hora de la sustentación sea programada en un horario hábil institucional.

  * [ ] Registrar la nota promedio final (debe encontrarse en el rango de 0.00 a 20.00).
  * [ ] Generar el número de acta correlativo único e inalterable al concretar la sustentación aprobada.
* [ ] Detallar los Casos de Uso del módulo de sustentaciones:
  * [ ] Caso de Uso: Programar Sustentación de Proyecto de Tesis
  * [ ] Caso de Uso: Reprogramar Fecha, Hora o Ubicación de Sustentación
  * [ ] Caso de Uso: Suspender Sustentación Programada Administrativamente
  * [ ] Caso de Uso: Registrar Calificación y Nota Final de Sustentación
  * [ ] Caso de Uso: Generar Acta de Sustentación con Número Correlativo Único



## Semana 11: 10 de Agosto al 15 de Agosto
* Horas semanales: 24
* Horas acumuladas: 264
* Entregables: Módulo de Gestión Documental de Archivos de Tesis y Control de Versiones.

### Tareas y Actividades
* [ ] Definir la estructura de la tabla de Documentos (documents):
  * [ ] Campo id (bigint, primary key, auto_increment).
  * [ ] Campo record_id (bigint, foreign key, nullable).
  * [ ] Campo project_id (bigint, foreign key, nullable).
  * [ ] Campo file_path (string, not null).
  * [ ] Campo file_name (string, not null).
  * [ ] Campo type (enum: certificado_egreso, tesis_pdf, resolucion).
  * [ ] Campo version (integer).
* [ ] Desarrollar lógica del controlador de documentos (DocumentController.php) a nivel funcional:
  * [ ] Método upload(): Procesar carga de archivos en disco seguro y privado.
  * [ ] Validar tipo MIME (permitir únicamente extensiones pdf y docx).
  * [ ] Validar tamaño de archivo (máximo 20 Megabytes).
  * [ ] Control de versiones: Incrementar automáticamente la versión si ya existe un documento cargado, manteniendo el histórico físico.
* [ ] Detallar los Casos de Uso del módulo de gestión documental:
  * [ ] Caso de Uso: Subir Documento Requerido al Expediente
  * [ ] Caso de Uso: Subir Borrador de Tesis al Proyecto
  * [ ] Caso de Uso: Descargar Documento Adjunto del Expediente
  * [ ] Caso de Uso: Registrar Nueva Versión del Documento de Tesis
  * [ ] Caso de Uso: Consultar Historial de Versiones del Archivo de Tesis



## Semana 12: 17 de Agosto al 22 de Agosto
* Horas semanales: 24
* Horas acumuladas: 288
* Entregables: Pruebas Funcionales de Control de Calidad del Proceso.

### Tareas y Actividades
* [ ] Codificar pruebas funcionales en RecordTest.php:
  * [ ] Probar la transición secuencial de estados del expediente de titulación.
  * [ ] Verificar la inyección de registros en la bitácora de auditoría histórica.
  * [ ] Validar las restricciones de cambio de estado cuando faltan documentos requeridos.
  * [ ] Probar el rechazo de asignación de asesor cuando supera el límite de 5 proyectos activos.
  * [ ] Probar el rechazo de programación de sustentación ante conflicto de horario o de aula.
* [ ] Detallar Casos de Uso específicos de pruebas de calidad:
  * [ ] Caso de Uso: Ejecutar Prueba de Transición de Estados del Expediente
  * [ ] Caso de Uso: Ejecutar Prueba de Límite de Proyectos del Asesor
  * [ ] Caso de Uso: Ejecutar Prueba de Cruce de Horarios de Jurados y Aulas
  * [ ] Caso de Uso: Verificar Consistencia de Estado del Estudiante en Graduaciones



## Semana 13: 24 de Agosto al 25 de Agosto
* Horas semanales: 2
* Horas acumuladas: 290
* Entregables: Manual de Usuario y Casos de Uso Finales.

### Tareas y Actividades
* [ ] Redactar el manual funcional del usuario final -> `../docs/manual_usuario.md`
  * [ ] Explicar el flujo paso a paso de carga de expediente de titulación por parte de estudiantes.
  * [ ] Explicar la línea de tiempo visual y el método para corregir observaciones académicas registradas.
  * [ ] Detallar la gestión de proyectos de tesis y la asignación del asesor académico del estudiante.
* [ ] Detallar los Casos de Uso del manual de usuario:
  * [ ] Caso de Uso: Consultar Manual del Usuario Estudiante
  * [ ] Caso de Uso: Consultar Manual del Usuario Evaluador Académico
  * [ ] Caso de Uso: Consultar Manual del Usuario Jurado de Tesis



## SECCIÓN VIII: ESPECIFICACIONES DETALLADAS DE PROCESOS ( walkthrough conceptual )

### 1. Motor de Estados del Expediente de Titulación
El expediente del estudiante es el documento rector del trámite académico. Comienza en estado registrado al ser ingresado por primera vez en la interfaz. Al cambiar a en revisión, el sistema bloquea cualquier modificación en la información del estudiante por parte de éste, permitiendo únicamente al evaluador o al administrador modificar campos o añadir observaciones de rechazo.

Si el expediente cuenta con observaciones (por ejemplo, falta el certificado de egreso o el formato de tesis en PDF no es correcto), pasa al estado subsanado una vez que el estudiante carga el archivo corregido. El evaluador entonces tiene la facultad de pasarlo a aprobado. Finalmente, el estado de apto para sustentación se adquiere al completarse satisfactoriamente todas las firmas e informes previos. Cada una de estas transiciones es validada a nivel de base de datos a través de una transacción atómica que inserta una fila de auditoría en record_histories para rastrear tiempos y responsables.

### 2. Reglas del Asesor Académico y Proyectos
Un docente sólo puede asesorar un máximo de 5 proyectos activos a la vez. Cuando se realiza una solicitud de asignación de asesor, el sistema realiza una consulta selectiva para contar los registros activos en advisor_assignments para el docente especificado. Si el conteo es igual a 5, el controlador detiene la operación y retorna una respuesta de validación indicando que el profesor se encuentra a su máxima capacidad.

Adicionalmente, se ejecuta una consulta para comprobar la escuela profesional del docente respecto a la del estudiante solicitante. Si el docente pertenece a otra carrera profesional no habilitada, se deniega la postulación. En caso de cambio de tutor o retiro del proyecto, la asignación existente se actualiza a estado inactivo y se registra el nuevo asesor manteniendo el histórico de asesoramiento.

### 3. Evitación de Conflictos en Sustentaciones
La programación de sustentaciones requiere comprobar tres variables para garantizar que la sesión se ejecute sin contratiempos:
* Disponibilidad del Aula: Se comprueba la tabla defenses para buscar eventos programados en el mismo local a la misma fecha y hora. Se considera un margen de seguridad de 2 horas. Si existe cruce, la transacción se aborta.
* Disponibilidad de Jurados: Se realiza una consulta relacional sobre la tabla jury_assignments y defenses para buscar a los tres jurados asignados (presidente, secretario, vocal). Si alguno de ellos tiene una sustentación programada a esa hora, el sistema de validación de procesos académicos rechaza la programación.
* Modalidades de Calificación: El acta de sustentación correlativa única sólo se genera cuando el estado de la sustentación se actualiza a aprobado. La nota registrada debe encontrarse en un rango de 0.00 a 20.00 y no puede ser modificada posteriormente sin resolución del consejo de carrera.

### 4. Gestión Documental Inmutable
Cada archivo de tesis o certificado subido al sistema de almacenamiento debe cumplir con parámetros estrictos. La ruta física en disco se genera utilizando el ID del expediente o proyecto, segmentando los directorios para mayor orden en el almacenamiento. Si se carga una actualización del mismo documento, el sistema no borra el archivo anterior, sino que actualiza su versión en base de datos e incrementa el contador correlativo en la tabla documents, garantizando un histórico completo de la evolución de la tesis del alumno para su posterior revisión por el jurado.



## SECCIÓN IX: ESPECIFICACIONES DE CONTROLADORES Y VALIDACIONES DETALLADAS

### 1. Validaciones en RecordController.php
* store(): El request requiere validar obligatoriamente que `student_id` pertenezca a la tabla de estudiantes y que `career_id` corresponda a una carrera válida registrada en la tabla de carreras. La fecha de inicio del trámite `initiated_date` debe ser una fecha válida en formato año-mes-día (Y-m-d) y debe ser igual o anterior a la fecha actual del servidor.
* updateStatus(): Al cambiar el estado de un expediente, la entrada `new_status` debe restringirse a uno de los valores definidos en la enumeración (registrado, en_revision, subsanado, aprobado, apto_sustentacion). Si el nuevo estado es en_revision o subsanado, el campo `observation` puede ser opcional, pero si la transición es de rechazo o devolución por corrección, la observación debe ser obligatoria con un mínimo de 15 caracteres para asegurar una explicación comprensible para el alumno.

### 2. Validaciones en ProjectController.php y AdvisorAssignmentController.php
* store() en ProjectController.php: Requiere validar que `student_id` exista y no posea otro proyecto en estado propuesto o aprobado de forma concurrente, asegurando que un alumno sólo trabaje en una tesis por carrera profesional activa. El campo `title` debe tener una longitud mínima de 20 caracteres y un máximo de 500, mientras que `description` (resumen de la tesis) debe contar con al menos 100 caracteres.
* store() en AdvisorAssignmentController.php: Para registrar la asignación de tutor, se requiere validar que `project_id` exista en la tabla de proyectos y que `teacher_id` esté en la tabla de docentes. La fecha `assignment_date` debe validarse para que coincida o sea posterior a la fecha de aprobación del tema de tesis. Antes de guardar la asignación con estado activo, se debe validar mediante consulta SQL que el conteo de registros con `status = 'activo'` para el docente ingresado sea estrictamente menor a 5.

### 3. Validaciones en DefenseController.php
* store(): La fecha de sustentación `defense_date` debe ser una fecha y hora (Y-m-d H:i:s) posterior al momento actual (mínimo con 48 horas de anticipación). El campo de ubicación `location` es requerido con longitud máxima de 255 caracteres. El campo `jurors` debe ser un array con exactamente 3 elementos, validando individualmente que cada elemento tenga un `id` válido en la tabla de jurados y que los tres roles asignados sean únicos (debe haber obligatoriamente un presidente, un secretario y un vocal).
* Lógica de Cruces en Sustentaciones: Antes de proceder a persistir la sustentación y los jurados, el sistema ejecuta dos consultas de control:
  * Consulta de Aula: Buscar si hay alguna otra fila en defenses donde `location` sea igual al aula solicitada y donde el valor absoluto de la diferencia en minutos entre `defense_date` y la fecha de la otra sustentación sea menor a 120 minutos (2 horas).
  * Consulta de Jurados: Buscar en jury_assignments unida con defenses si alguno de los 3 jurados seleccionados tiene otra sustentación asignada en un rango de 2 horas antes o después de la hora planificada.
  * Si alguna consulta retorna un registro, la validación falla lanzando una excepción de validación y cancelando el guardado.

### 4. Validaciones de Gestión Documental en DocumentController.php
* upload(): El archivo subido bajo el parámetro `file` debe ser obligatorio y contar con la validación de tamaño máximo de 20480 kilobytes (20 megabytes). Se deben restringir las extensiones de archivos permitidas a tipos MIME específicos de PDF (application/pdf) y Word (application/vnd.openxmlformats-officedocument.wordprocessingml.document). El campo `type` debe restringirse a los tipos del enumerado de base de datos.
* Almacenamiento y Versión: Al recibir un archivo válido, el controlador comprueba si existe una fila en la tabla documents asociada al mismo `record_id` o `project_id` y con el mismo `type`. Si se encuentra un registro previo, se obtiene el valor máximo de la columna `version`, se incrementa en 1, y se almacena el archivo físico en disco con un sufijo de versión (ej. `tesis_v2.pdf`), guardando el nuevo registro en la base de datos sin sobreescribir el registro de la versión anterior para permitir auditoría histórica.
* Reglas de Auditoría y Control de Calidad Adicionales:
  * Toda modificación del estado de un expediente debe guardar obligatoriamente una bitácora en la tabla `record_histories` conteniendo el usuario de auditoría y la justificación.
  * Los expedientes con observaciones deben impedir el agendamiento de sustentación.
  * El acta correlativa no puede ser generada si existe alguna observación pendiente de subsanación.

