# Checklist de Avance Detallado - GUIDO (Backend, DB y Seguridad)

Este documento contiene la hoja de ruta, especificaciones de arquitectura y tareas de desarrollo backend organizadas por semana, horas y fechas para el programador GUIDO, encargado del diseño del esquema de base de datos, relaciones de modelos Eloquent, APIs, políticas de seguridad y pruebas backend.

* Duración total asignada: 290 horas (4 horas diarias, 6 días a la semana, excepto la última semana de 2 horas)
* Tecnología: Laravel 12, PHP 8.x, MariaDB



## Semana 1: 01 de Junio al 06 de Junio
* Horas semanales: 24
* Horas acumuladas: 24
* Entregables: Estructuras de Base de Datos y Modelos Eloquent de Estudiantes, Docentes y Carreras.

### Tareas y Actividades
* [x] Diseño e implementación de migraciones relacionales:
  * [x] Crear tabla de usuarios -> [0001_01_01_000000_create_users_table.php](../database/migrations/0001_01_01_000000_create_users_table.php)
  * [x] Definir columna id como clave primaria con incremento automático (bigIncrements) en tabla usuarios
  * [x] Definir columna name de tipo string para el nombre completo en tabla usuarios
  * [x] Definir columna email de tipo string con índice único para el inicio de sesión en tabla usuarios
  * [x] Definir columna email_verified_at de tipo timestamp y nullable para verificación en tabla usuarios
  * [x] Definir columna password de tipo string para almacenar la clave hash en tabla usuarios
  * [x] Definir columna remember_token de tipo string y nullable en tabla usuarios
  * [x] Definir columnas created_at y updated_at mediante la directiva timestamps() en tabla usuarios
  * [x] Crear tabla de estudiantes -> [2026_06_02_021259_create_students_table.php](../database/migrations/2026_06_02_021259_create_students_table.php)
  * [x] Definir clave primaria id de tipo bigint con incremento automático en tabla estudiantes
  * [x] Definir columna name de tipo string para el nombre completo del alumno en tabla estudiantes
  * [x] Definir columna document_number de tipo string con índice único en tabla estudiantes
  * [x] Definir columna email de tipo string y nullable en tabla estudiantes
  * [x] Definir columna phone de tipo string y nullable en tabla estudiantes
  * [x] Definir columna status de tipo string para controlar el estado académico en tabla estudiantes
  * [x] Definir columna enrollment_date de tipo date para la fecha de ingreso en tabla estudiantes
  * [x] Definir columna graduation_date de tipo date y nullable en tabla estudiantes
  * [x] Definir columnas created_at y updated_at mediante timestamps() en tabla estudiantes
  * [x] Crear tabla de docentes -> [2026_06_02_022143_create_teachers_table.php](../database/migrations/2026_06_02_022143_create_teachers_table.php)
  * [x] Definir clave primaria id de tipo bigint con incremento automático en tabla docentes
  * [x] Definir columna name de tipo string para el nombre completo en tabla docentes
  * [x] Definir columna document_number de tipo string con índice único en tabla docentes
  * [x] Definir columna email de tipo string con índice único en tabla docentes
  * [x] Definir columna phone de tipo string y nullable en tabla docentes
  * [x] Definir columna specialty de tipo string para el área de conocimiento en tabla docentes
  * [x] Definir columna status de tipo string para la disponibilidad en tabla docentes
  * [x] Definir columna hire_date de tipo date para la fecha de contratación en tabla docentes
  * [x] Definir columnas created_at y updated_at mediante timestamps() en tabla docentes
  * [x] Crear tabla de carreras profesionales -> [2026_06_02_023000_create_careers_table.php](../database/migrations/2026_06_02_023000_create_careers_table.php)
  * [x] Definir clave primaria id de tipo bigint con incremento automático en tabla carreras
  * [x] Definir columna name de tipo string para el nombre de la escuela en tabla carreras
  * [x] Definir columna code de tipo string con índice único en tabla carreras
  * [x] Definir columna status de tipo string en tabla carreras
  * [x] Definir columnas created_at y updated_at mediante timestamps() en tabla carreras
  * [x] Crear tabla pivote de carreras y estudiantes -> [2026_06_02_024000_create_career_student_table.php](../database/migrations/2026_06_02_024000_create_career_student_table.php)
  * [x] Definir columna id como clave primaria en tabla pivote career_student
  * [x] Definir student_id de tipo bigint en tabla pivote career_student
  * [x] Configurar student_id con clave foránea referenciando a tabla estudiantes
  * [x] Definir career_id de tipo bigint en tabla pivote career_student
  * [x] Configurar career_id con clave foránea referenciando a tabla carreras
  * [x] Configurar student_id con borrado en cascada (onDelete('cascade')) en career_student
  * [x] Configurar career_id con borrado en cascada (onDelete('cascade')) en career_student
  * [x] Establecer un índice compuesto único (student_id, career_id) en career_student
  * [x] Definir columnas created_at y updated_at en career_student
  * [x] Crear tabla pivote de docentes y carreras -> [2026_06_02_025000_create_career_teacher_table.php](../database/migrations/2026_06_02_025000_create_career_teacher_table.php)
  * [x] Definir columna id como clave primaria en tabla pivote career_teacher
  * [x] Definir teacher_id de tipo bigint en tabla pivote career_teacher
  * [x] Configurar teacher_id con clave foránea referenciando a tabla docentes
  * [x] Definir career_id de tipo bigint en tabla pivote career_teacher
  * [x] Configurar career_id con clave foránea referenciando a tabla carreras
  * [x] Configurar teacher_id con borrado en cascada (onDelete('cascade')) en career_teacher
  * [x] Configurar career_id con borrado en cascada (onDelete('cascade')) en career_teacher
  * [x] Establecer un índice compuesto único (teacher_id, career_id) en career_teacher
  * [x] Definir columnas created_at y updated_at en career_teacher
* [x] Configuración de Modelos y Relaciones Eloquent:
  * [x] Configurar asignación masiva ($fillable) en modelo User.php
  * [x] Configurar campos ocultos ($hidden) para contraseña en modelo User.php
  * [x] Configurar casts de contraseña en modelo User.php
  * [x] Configurar asignación masiva ($fillable) en modelo Student.php
  * [x] Definir relación careers() de tipo belongsToMany en modelo Student.php
  * [x] Configurar asignación masiva ($fillable) en modelo Teacher.php
  * [x] Definir relación careers() de tipo belongsToMany en modelo Teacher.php
  * [x] Configurar asignación masiva ($fillable) en modelo Career.php
  * [x] Definir relación students() de tipo belongsToMany en modelo Career.php
  * [x] Definir relación teachers() de tipo belongsToMany en modelo Career.php
* [x] Configuración de Seeders y Model Factories:
  * [x] Crear StudentFactory para simular registros de estudiantes en desarrollo
  * [x] Crear TeacherFactory para simular registros de docentes en desarrollo
  * [x] Crear CareerFactory para simular registros de escuelas profesionales
  * [x] Crear UserSeeder para poblar usuarios iniciales con roles definidos
  * [x] Crear StudentSeeder para poblar datos de prueba con carreras asignadas
  * [x] Crear TeacherSeeder para poblar datos de docentes y especialidades
  * [x] Crear CareerSeeder para registrar las escuelas profesionales iniciales
  * [x] Configurar DatabaseSeeder para ejecutar todos los seeders en orden secuencial



## Semana 2: 08 de Junio al 13 de Junio
* Horas semanales: 24
* Horas acumuladas: 48
* Entregables: Controladores de Autenticación y Seguridad de Sesión.

### Tareas y Actividades
* [x] Implementar controladores de autenticación en app/Http/Controllers/Auth/:
  * [x] Crear LoginController.php para autenticar usuarios con email y password
  * [x] Definir lógica para procesar la autenticación en LoginController.php
  * [x] Configurar límites de intentos fallidos (throttling) en LoginController.php
  * [x] Redireccionar a la ruta correcta según el rol en LoginController.php
  * [x] Crear RegisterController.php para registrar nuevos usuarios del sistema
  * [x] Establecer reglas de validación para campos en RegisterController.php
  * [x] Validar que el email sea único en tabla usuarios en RegisterController.php
  * [x] Cifrar contraseña utilizando Hash::make en RegisterController.php
  * [x] Crear ConfirmPasswordController.php para requerir contraseña en acciones críticas
  * [x] Definir lógica para comprobar si la sesión requiere clave en ConfirmPasswordController.php
  * [x] Crear ForgotPasswordController.php para recuperar contraseña
  * [x] Configurar plantilla y envío de enlace mediante email en ForgotPasswordController.php
  * [x] Crear ResetPasswordController.php para restablecer contraseña con token
  * [x] Validar token de seguridad y actualizar contraseña en ResetPasswordController.php
  * [x] Crear VerificationController.php para verificar email
  * [x] Gestionar la verificación de correo electrónico en VerificationController.php
* [x] Registrar la declaración de rutas de autenticación en routes/web.php utilizando Auth::routes()
* [x] Asignar el middleware auth en el archivo de rutas para proteger las vistas operativas



## Semana 3: 15 de Junio al 20 de Junio
* Horas semanales: 24
* Horas acumuladas: 72
* Entregables: Controladores CRUD Backend de Estudiantes y Docentes.

### Tareas y Actividades
* [x] Desarrollo del controlador backend de Estudiantes -> [StudentController.php](../app/Http/Controllers/StudentController.php)
  * [x] Implementar método index() para listar estudiantes en StudentController.php
  * [x] Cargar alumnos paginados (10 por página) en StudentController.php
  * [x] Cargar relación careers (with('careers')) para evitar consultas N+1 en StudentController.php
  * [x] Aplicar filtros opcionales de nombre en index() de StudentController.php
  * [x] Aplicar filtros de carrera profesional en index() de StudentController.php
  * [x] Implementar método store() para guardar estudiantes en StudentController.php
  * [x] Validar datos recibidos (name requerido, document_number requerido y único) en store()
  * [x] Validar correo electrónico en formato correcto en store() de StudentController.php
  * [x] Validar fecha de ingreso (enrollment_date) en store() de StudentController.php
  * [x] Guardar estudiante en la base de datos en store() de StudentController.php
  * [x] Sincronizar carreras mediante sync() en store() de StudentController.php
  * [x] Iniciar transacción de base de datos DB::beginTransaction() en store()
  * [x] Confirmar transacción DB::commit() tras guardado exitoso en store()
  * [x] Capturar excepciones y realizar rollback DB::rollBack() ante fallas en store()
  * [x] Implementar método show() para ver ficha de estudiante en StudentController.php
  * [x] Cargar información académica e historial de carreras en show() de StudentController.php
  * [x] Implementar método update() para editar estudiantes en StudentController.php
  * [x] Validar datos recibidos en update() de StudentController.php
  * [x] Asegurar que document_number sea único exceptuando el ID editado en update()
  * [x] Actualizar datos del estudiante en la base de datos en update() de StudentController.php
  * [x] Sincronizar carreras mediante sync() en update() de StudentController.php
  * [x] Implementar método destroy() para eliminar estudiantes en StudentController.php
  * [x] Eliminar relaciones en la tabla pivote en destroy() de StudentController.php
  * [x] Realizar la eliminación física de la tabla en destroy() de StudentController.php
  * [x] Manejar QueryException específica de base de datos en destroy() de StudentController.php
* [x] Desarrollo del controlador backend de Docentes -> [TeacherController.php](../app/Http/Controllers/TeacherController.php)
  * [x] Implementar método index() para listar docentes en TeacherController.php
  * [x] Obtener listado de docentes paginado en index() de TeacherController.php
  * [x] Integrar filtros de búsqueda por nombre en index() de TeacherController.php
  * [x] Integrar filtros de búsqueda por especialidad en index() de TeacherController.php
  * [x] Implementar método store() para guardar docentes en TeacherController.php
  * [x] Validar datos obligatorios (document_number único, email único) en store()
  * [x] Insertar el registro de docente en base de datos en store() de TeacherController.php
  * [x] Sincronizar carreras asociadas en store() de TeacherController.php
  * [x] Iniciar transacción DB::beginTransaction() en store() de TeacherController.php
  * [x] Confirmar transacción DB::commit() en store() de TeacherController.php
  * [x] Realizar rollback DB::rollBack() en caso de falla en store() de TeacherController.php
  * [x] Implementar método update() para modificar docentes en TeacherController.php
  * [x] Validar cambios controlando exclusiones de clave única en update()
  * [x] Actualizar registro en base de datos en update() de TeacherController.php
  * [x] Implementar método destroy() para eliminar docentes en TeacherController.php
  * [x] Desvincular carreras asociadas en tabla pivote en destroy() de TeacherController.php
  * [x] Eliminar docente de la tabla en destroy() de TeacherController.php



## Semana 4: 22 de Junio al 27 de Junio
* Horas semanales: 24
* Horas acumuladas: 96
* Entregables: Controlador CRUD Backend de Carreras Profesionales.

### Tareas y Actividades
* [x] Desarrollo del controlador backend de Carreras -> [CareerController.php](../app/Http/Controllers/CareerController.php)
  * [x] Implementar método index() para listar carreras en CareerController.php
  * [x] Retornar listado de carreras paginado en index() de CareerController.php
  * [x] Soporte para filtros por nombre de carrera en index() de CareerController.php
  * [x] Soporte para filtros por código identificador en index() de CareerController.php
  * [x] Implementar método store() para guardar carreras en CareerController.php
  * [x] Validar name requerido y único en store() de CareerController.php
  * [x] Validar code requerido y único en store() de CareerController.php
  * [x] Guardar carrera profesional con estado activo por defecto en store()
  * [x] Implementar método update() para modificar carreras en CareerController.php
  * [x] Permitir actualización de nombre en update() de CareerController.php
  * [x] Permitir actualización de código en update() de CareerController.php
  * [x] Permitir actualización de estado de la carrera en update() de CareerController.php
  * [x] Implementar método destroy() para eliminar carreras en CareerController.php
  * [x] Comprobar si existen alumnos vinculados antes de eliminar en destroy()
  * [x] Comprobar si existen docentes vinculados antes de eliminar en destroy()
  * [x] Eliminar registro de carrera en destroy() de CareerController.php



## Semana 5: 29 de Junio al 04 de Julio
* Horas semanales: 24
* Horas acumuladas: 120
* Entregables: Base de Datos y Controladores para Gestión de Matrículas y Soporte Multi-Carrera.

### Tareas y Actividades
* [ ] Crear migración para periodos académicos -> [2026_07_01_000001_create_academic_periods_table.php](../database/migrations/2026_07_01_000001_create_academic_periods_table.php)
  * [ ] Definir columna id como clave primaria (bigIncrements) en academic_periods
  * [ ] Definir columna name de tipo string en academic_periods
  * [ ] Establecer índice único para la columna name en academic_periods
  * [ ] Definir columna start_date de tipo date en academic_periods
  * [ ] Definir columna end_date de tipo date en academic_periods
  * [ ] Definir columna status de tipo string para el estado en academic_periods
  * [ ] Definir columnas created_at y updated_at mediante la directiva timestamps() en academic_periods
* [ ] Crear migración para matrículas de estudiantes -> [2026_07_01_000002_create_enrollments_table.php](../database/migrations/2026_07_01_000002_create_enrollments_table.php)
  * [ ] Definir columna id como clave primaria en enrollments
  * [ ] Definir student_id de tipo bigint en enrollments
  * [ ] Configurar student_id con referencia foránea a estudiantes con onDelete('restrict')
  * [ ] Definir career_id de tipo bigint en enrollments
  * [ ] Configurar career_id con referencia foránea a carreras con onDelete('restrict')
  * [ ] Definir academic_period_id de tipo bigint en enrollments
  * [ ] Configurar academic_period_id con referencia foránea a periodos académicos con onDelete('restrict')
  * [ ] Definir columna enrollment_date de tipo date en enrollments
  * [ ] Definir columna status de tipo string (activo, reserva, retirado) en enrollments
  * [ ] Establecer índice compuesto único (student_id, career_id, academic_period_id) en enrollments
  * [ ] Definir columnas created_at y updated_at en enrollments
* [ ] Implementar Modelo AcademicPeriod.php en app/Models/:
  * [ ] Declarar propiedad $fillable con name, start_date, end_date, status
  * [ ] Definir relación enrollments() de tipo hasMany hacia Enrollment
  * [ ] Crear query scope scopeActive para filtrar periodos académicos activos
* [ ] Implementar Modelo Enrollment.php en app/Models/:
  * [ ] Declarar propiedad $fillable con student_id, career_id, academic_period_id, enrollment_date, status
  * [ ] Definir relación student() de tipo belongsTo hacia Student
  * [ ] Definir relación career() de tipo belongsTo hacia Career
  * [ ] Definir relación academicPeriod() de tipo belongsTo hacia AcademicPeriod
  * [ ] Crear query scope scopeActiveEnrollments para filtrar matrículas activas
* [ ] Desarrollar clases Form Request para validación de datos:
  * [ ] Crear StoreAcademicPeriodRequest para validar la creación de periodos académicos
  * [ ] Validar que name sea único en academic_periods en StoreAcademicPeriodRequest
  * [ ] Validar que start_date sea una fecha válida en StoreAcademicPeriodRequest
  * [ ] Validar que end_date sea una fecha posterior a start_date en StoreAcademicPeriodRequest
  * [ ] Crear StoreEnrollmentRequest para validar el registro de matrículas
  * [ ] Validar student_id requerido y existente en tabla estudiantes en StoreEnrollmentRequest
  * [ ] Validar career_id requerido y existente en tabla carreras en StoreEnrollmentRequest
  * [ ] Validar academic_period_id requerido y existente en StoreEnrollmentRequest
  * [ ] Validar status requerido con valores (activo, reserva, retirado) en StoreEnrollmentRequest
* [ ] Desarrollar controlador AcademicPeriodController.php:
  * [ ] Implementar método index() para listar periodos con paginación
  * [ ] Implementar método store() utilizando StoreAcademicPeriodRequest
  * [ ] Transacción para desactivar otros periodos si el nuevo es activo en store()
  * [ ] Implementar método update() para modificar fechas y estados del ciclo
  * [ ] Implementar método destroy() controlando que no existan matrículas asociadas
* [ ] Desarrollar controlador EnrollmentController.php:
  * [ ] Crear método index() con filtros combinados por periodo académico y carrera profesional
  * [ ] Cargar relaciones with('student', 'career', 'academicPeriod') en index()
  * [ ] Crear método store() utilizando la clase StoreEnrollmentRequest
  * [ ] Validar que el estudiante pertenezca a la carrera elegida (career_student) en store()
  * [ ] Validar que el estudiante esté activo en la tabla estudiantes en store()
  * [ ] Validar que la fecha de matrícula esté dentro de límites de fecha del periodo en store()
  * [ ] Controlar excepciones de base de datos ante índices únicos duplicados en store()
  * [ ] Implementar método update() para cambiar estados de matrícula (reserva, retirado)
  * [ ] Implementar método destroy() para remover matrículas por error administrativo



## Semana 6: 06 de Julio al 11 de Julio
* Horas semanales: 24
* Horas acumuladas: 144
* Entregables: Base de Datos y Controlador para Registro de Egresados y Grados de Titulación.

### Tareas y Actividades
* [ ] Crear migración para registro de titulación -> [2026_07_01_000003_create_degrees_table.php](../database/migrations/2026_07_01_000003_create_degrees_table.php)
  * [ ] Definir clave primaria id de tipo bigint con incremento automático en degrees
  * [ ] Definir student_id de tipo bigint en degrees
  * [ ] Configurar student_id con referencia foránea a tabla estudiantes con onDelete('restrict')
  * [ ] Definir career_id de tipo bigint en degrees
  * [ ] Configurar career_id con referencia foránea a tabla carreras con onDelete('restrict')
  * [ ] Definir columna status de tipo string (egresado, en_tramite, titulado) en degrees
  * [ ] Definir columna metodo_titulacion de tipo string y nullable en degrees
  * [ ] Definir columna fecha_titulacion de tipo date y nullable en degrees
  * [ ] Definir columna numero_resolucion de tipo string, nullable and de valor único en degrees
  * [ ] Establecer un índice compuesto único (student_id, career_id) en degrees
  * [ ] Definir columnas de tiempo timestamps() en degrees
* [ ] Implementar Modelo Degree.php en app/Models/:
  * [ ] Declarar propiedad $fillable para asignación de campos
  * [ ] Definir relación student() de tipo belongsTo hacia Student
  * [ ] Definir relación career() de tipo belongsTo hacia Career
  * [ ] Crear query scope scopeTitled para filtrar graduados titulados
  * [ ] Crear query scope scopeGraduated para filtrar graduados egresados
* [ ] Desarrollar clase Form Request para validación del grado académico:
  * [ ] Crear StoreDegreeRequest para validar el registro de grados
  * [ ] Validar student_id requerido y existente en tabla estudiantes en StoreDegreeRequest
  * [ ] Validar career_id requerido y existente en tabla carreras en StoreDegreeRequest
  * [ ] Validar status requerido con valores (egresado, en_tramite, titulado) en StoreDegreeRequest
  * [ ] Validar metodo_titulacion condicional (requerido si status es titulado o en_tramite)
  * [ ] Validar numero_resolucion condicional y de valor único en degrees en StoreDegreeRequest
* [ ] Desarrollar controlador DegreeController.php:
  * [ ] Crear método index() para mostrar egresados y titulados con filtros
  * [ ] Crear método store() utilizando la clase StoreDegreeRequest
  * [ ] Envolver inserción e inicio de grado en transacción DB::transaction en store()
  * [ ] Actualizar estado de estudiante a egresado/titulado en students en store()
  * [ ] Registrar fecha de egreso/graduación final en students en store()
  * [ ] Validar obligatoriedad del número de resolución si el estado es titulado en store()
  * [ ] Implementar método update() para modificar resoluciones y fechas
  * [ ] Implementar método destroy() para corregir registros erróneos



## Semana 7: 13 de Julio al 18 de Julio
* Horas semanales: 24
* Horas acumuladas: 168
* Entregables: APIs de Consulta y Optimización de Base de Datos para Expedientes.

### Tareas y Actividades
* [ ] Diseñar esquema relacional y migración para la tabla de expedientes (records):
  * [ ] Definir tabla records con campos id, student_id, career_id, code, current_status, initiated_date
  * [ ] Configurar clave única en records para la columna code
  * [ ] Configurar claves foráneas student_id y career_id con restricción de borrado en records
* [ ] Diseñar esquema relacional y migración para tabla bitácora de expedientes (record_histories):
  * [ ] Definir tabla record_histories con campos id, record_id, previous_status, new_status, observation, user_id
  * [ ] Configurar clave foránea record_id hacia records y user_id hacia users en record_histories
* [ ] Desarrollar consultas optimizadas con Eloquent utilizando eager loading complejo:
  * [ ] Cargar relaciones with('student', 'career', 'documents', 'histories') en consultas
  * [ ] Evitar consultas recurrentes N+1 en las vistas Blade de detalle
* [ ] Escribir consultas de rendimiento para filtrar expedientes por estado y escuela profesional
* [ ] Diseñar y ejecutar migración para agregar índices secundarios de optimización en base de datos:
  * [ ] Crear índice en columna status de tabla estudiantes
  * [ ] Crear índice en columna current_status de tabla expedientes (records)
  * [ ] Crear índice en columna record_id de tabla record_histories
  * [ ] Crear índice en columna student_id de tabla expedientes (records)
* [ ] Optimización y consultas específicas para expedientes:
  * [ ] Implementar transacciones de base de datos para la eliminación física o lógica de expedientes
  * [ ] Optimizar la consulta en base de datos para recuperar expedientes con la cantidad total de historial
  * [ ] Diseñar estructuras de respuestas JSON en APIs para la visualización detallada del expediente
  * [ ] Definir respuestas JSON estructuradas de error para adjuntos faltantes en el expediente
  * [ ] Mapear de forma detallada los estados históricos en el modelo RecordHistory
  * [ ] Crear scopes de consulta en Record.php para filtrado por estado
  * [ ] Crear scopes de consulta en Record.php para filtrar por escuela profesional
  * [ ] Escribir pruebas básicas unitarias para los métodos del controlador RecordController
  * [ ] Simular autenticación de usuario en pruebas del controlador RecordController para verificar políticas



## Semana 8: 20 de Julio al 25 de Julio
* Horas semanales: 24
* Horas acumuladas: 192
* Entregables: Base de Datos y Controlador para Habilitación de Jurados.

### Tareas y Actividades
* [ ] Crear migración para tabla de jurados habilitados -> [2026_07_01_000005_create_jurors_table.php](../database/migrations/2026_07_01_000005_create_jurors_table.php)
  * [ ] Definir columna id como clave primaria en jurors
  * [ ] Definir columna teacher_id de tipo bigint con índice único en jurors
  * [ ] Configurar clave foránea teacher_id hacia docentes con onDelete('cascade')
  * [ ] Definir columna status de tipo string (activo/inactivo) en jurors
  * [ ] Definir columnas created_at y updated_at en jurors
* [ ] Crear migración para tabla de asignación de jurados -> [2026_07_01_000006_create_jury_assignments_table.php](../database/migrations/2026_07_01_000006_create_jury_assignments_table.php)
  * [ ] Definir columna id como clave primaria en jury_assignments
  * [ ] Definir columna defense_id de tipo bigint en jury_assignments
  * [ ] Configurar clave foránea defense_id hacia sustentaciones con onDelete('cascade')
  * [ ] Definir columna juror_id de tipo bigint en jury_assignments
  * [ ] Configurar clave foránea juror_id hacia jurados con onDelete('restrict')
  * [ ] Definir columna role de tipo string (presidente, secretario, vocal) en jury_assignments
  * [ ] Establecer índice compuesto único (defense_id, juror_id) en jury_assignments
  * [ ] Definir columnas created_at y updated_at en jury_assignments
* [ ] Implementar Modelos Juror.php y JuryAssignment.php en app/Models/:
  * [ ] Definir relación teacher() de tipo belongsTo en Juror hacia Teacher
  * [ ] Definir relación assignments() de tipo hasMany en Juror hacia JuryAssignment
  * [ ] Definir relación juror() de tipo belongsTo en JuryAssignment hacia Juror
  * [ ] Definir relación defense() de tipo belongsTo en JuryAssignment hacia Defense
* [ ] Desarrollar Form Requests para validación de jurados:
  * [ ] Crear StoreJurorRequest para validar el registro de habilitación de jurados
  * [ ] Validar teacher_id requerido y único en tabla jurors en StoreJurorRequest
  * [ ] Crear StoreJuryAssignmentRequest para validar la asignación a una terna
  * [ ] Validar defense_id requerido y existente en StoreJuryAssignmentRequest
  * [ ] Validar juror_id requerido y existente en StoreJuryAssignmentRequest
  * [ ] Validar role requerido con opciones (presidente, secretario, vocal) en StoreJuryAssignmentRequest
* [ ] Desarrollar controlador JurorController.php:
  * [ ] Programar CRUD para habilitar y deshabilitar docentes en el rol de jurado
  * [ ] Implementar método index() con filtros de docentes jurados en JurorController.php
  * [ ] Validar que un docente inhabilitado no pueda ser asignado a sustentaciones en JurorController.php
  * [ ] Implementar toggleStatus() para deshabilitar jurados en JurorController.php



## Semana 9: 27 de Julio al 01 de Agosto
* Horas semanales: 24
* Horas acumuladas: 216
* Entregables: APIs y Reglas de Validación para Proyectos de Tesis y Asesores.

### Tareas y Actividades
* [ ] Diseñar el esquema de base de datos para proyectos de tesis (projects):
  * [ ] Definir tabla projects con campos id, student_id, title, description, status, timestamps
  * [ ] Configurar student_id como clave foránea referenciando a tabla estudiantes
* [ ] Diseñar el esquema de base de datos para asignación de asesores (advisor_assignments):
  * [ ] Definir tabla advisor_assignments con campos id, project_id, teacher_id, assignment_date, status, timestamps
  * [ ] Configurar project_id como clave foránea referenciando a tabla proyectos
  * [ ] Configurar teacher_id como clave foránea referenciando a tabla docentes
* [ ] Desarrollar clase de regla de validación personalizada (Custom Validation Rule) en Laravel:
  * [ ] Crear clase de regla AdvisorCapacityRule para validar la capacidad del asesor
  * [ ] Programar regla AdvisorCapacityRule para contar proyectos activos del docente
  * [ ] Lanzar error si el docente cuenta con 5 o más proyectos asignados
  * [ ] Programar mensaje de error detallado en español para la regla
* [ ] Desarrollar Form Requests para proyectos y asesores:
  * [ ] Crear StoreProjectRequest para validar la creación de proyectos de investigación
  * [ ] Validar title requerido, mínimo 20 y máximo 500 caracteres en StoreProjectRequest
  * [ ] Validar description requerida, mínimo 100 caracteres en StoreProjectRequest
  * [ ] Crear StoreAdvisorAssignmentRequest para la asignación de tutor
  * [ ] Validar project_id y teacher_id requeridos y existentes en StoreAdvisorAssignmentRequest
  * [ ] Aplicar regla AdvisorCapacityRule al campo teacher_id en la asignación
* [ ] Desarrollar validaciones de concordancia académica en la API:
  * [ ] Comparar carrera profesional del estudiante con el departamento de adscripción del profesor
  * [ ] Lanzar error de validación si no pertenecen a la misma especialidad/facultad
* [ ] Desarrollar lógica en el controlador de asignaciones para dar de baja asignaciones previas:
  * [ ] Implementar método para inactivar de forma automática al asesor anterior al registrar uno nuevo
  * [ ] Ejecutar re-asignaciones bajo transacciones atómicas DB::transaction()



## Semana 10: 03 de Agosto al 08 de Agosto
* Horas semanales: 24
* Horas acumuladas: 240
* Entregables: Lógica de Validación de Fechas y Aulas para Sustentaciones.

### Tareas y Actividades
* [ ] Programar lógica de validación en StoreDefenseRequest para la programación de sustentaciones:
  * [ ] Validar disponibilidad del aula física mediante consulta a base de datos
  * [ ] Asegurar que el local no registre otra sustentación dentro de un rango de 2 horas (120 minutos)
  * [ ] Validar disponibilidad de los 3 jurados seleccionados (presidente, secretario, vocal)
  * [ ] Consultar que los jurados no tengan cruces de sustentaciones en el rango de 2 horas
  * [ ] Validar que el array de jurados contenga exactamente tres jurados distintos
  * [ ] Validar que los cargos de presidente, secretario y vocal estén asignados una sola vez
  * [ ] Comprobar que el proyecto asociado esté en estado aprobado antes de programar
  * [ ] Lanzar excepciones de validación de formulario (StoreDefenseRequest)
  * [ ] Lanzar excepciones de validación estructuradas en formato JSON ante conflictos de horarios



## Semana 11: 10 de Agosto al 15 de Agosto
* Horas semanales: 24
* Horas acumuladas: 264
* Entregables: Servicio de Detección de Deserción Escolar y Políticas de Acceso (Policies).

### Tareas y Actividades
* [ ] Desarrollar el servicio lógico para detección de deserción escolar -> `app/Services/DropoutDetectionService.php`
  * [ ] Escribir consulta SQL utilizando Eloquent Builder en DropoutDetectionService.php
  * [ ] Recuperar estudiantes que registraron matrícula en el periodo anterior
  * [ ] Filtrar aquellos que no registran matrícula en el periodo actual
  * [ ] Retornar listado de alumnos en riesgo de abandono de estudios
* [ ] Configurar las políticas de acceso y seguridad basadas en roles (Policies) en app/Policies/:
  * [ ] Crear política de matrículas -> [EnrollmentPolicy.php](../app/Policies/EnrollmentPolicy.php)
  * [ ] Definir método viewAny() en la política EnrollmentPolicy.php
  * [ ] Definir método create() para limitar inscripción a coordinadores en EnrollmentPolicy.php
  * [ ] Crear política de expedientes -> [RecordPolicy.php](../app/Policies/RecordPolicy.php)
  * [ ] Asegurar que el estudiante sólo visualice su propio expediente en RecordPolicy.php
  * [ ] Permitir a evaluadores académicos modificar estados y observaciones en RecordPolicy.php
  * [ ] Registrar políticas de acceso en AuthServiceProvider.php de Laravel



## Semana 12: 17 de Agosto al 22 de Agosto
* Horas semanales: 24
* Horas acumuladas: 288
* Entregables: Suite de Pruebas Unitarias e Integración Backend.

### Tareas y Actividades
* [ ] Escribir pruebas funcionales y unitarias automatizadas con PHPUnit en tests/Feature/:
  * [ ] Crear suite de pruebas de matrículas -> [EnrollmentTest.php](../tests/Feature/EnrollmentTest.php)
  * [ ] Probar validación de matrícula duplicada en el mismo periodo en la suite de pruebas
  * [ ] Probar rechazo si el estudiante no pertenece a la carrera en la suite de pruebas
  * [ ] Crear suite de pruebas para la detección de deserción escolar -> [DropoutTest.php](../tests/Feature/DropoutTest.php)
  * [ ] Simular estudiantes matriculados en ciclo anterior sin registro en el actual en las pruebas
  * [ ] Validar exactitud del reporte del servicio en DropoutTest.php
  * [ ] Crear suite de pruebas para el flujo de egreso y titulación -> [DegreeTest.php](../tests/Feature/DegreeTest.php)
  * [ ] Verificar la actualización de estado a titulado en la base de datos tras el registro
  * [ ] Validar restricciones de número de resolución en DegreeTest.php
  * [ ] Probar validaciones del Form Request StoreDegreeRequest en la suite de pruebas
  * [ ] Probar políticas de acceso y denegación de roles en DegreeTest.php
  * [ ] Probar denegación de matrícula a estudiante inactivo en las pruebas de integración
  * [ ] Probar el cálculo correcto del índice de deserción bajo condiciones simuladas de periodos inactivos



## Semana 13: 24 de Agosto al 25 de Agosto
* Horas semanales: 2
* Horas acumuladas: 290
* Entregables: Documentación Técnica de Base de Datos y APIs.

### Tareas y Actividades
* [ ] Compilar manual técnico de arquitectura del backend en la carpeta de documentación del repositorio -> `./docs/manual_tecnico.md`
  * [ ] Escribir diccionario de datos completo conteniendo todos los tipos de campos
  * [ ] Documentar atributos, llaves y descripciones de las tablas de la base de datos
  * [ ] Documentar el comportamiento de las rutas de la API y parámetros esperados
  * [ ] Documentar las respuestas de validación y políticas de seguridad aplicadas
  * [ ] Validar esquemas SQL directamente contra MariaDB para confirmar consistencia
  * [ ] Realizar pruebas de carga en base de datos para medir el tiempo de respuesta de las consultas complejas de sustentación
  * [ ] Verificar la inmutabilidad de los registros de actas correlativos en base de datos
  * [ ] Verificar que no existan variables de entorno configuradas incorrectamente en producción
  * [ ] Revisar logs de depuración del servidor para eliminar cualquier salida innecesaria
  * [ ] Exportar estructura de base de datos final en formato SQL para control de versiones
  * [ ] Comprobar que todos los archivos PHP cumplan con los estándares PSR-12
  * [ ] Crear copia de seguridad local de la base de datos de desarrollo antes de la demostración final
  * [ ] Realizar una última revisión del archivo .env.example para asegurar que todas las claves requeridas estén presentes

