@extends("layouts.app")

@section("content")
<div class="container">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Detalles del Estudiante") }}</span>
                    <div>
                        <a href="{{ route("students.graduation.edit", $student->id) }}" class="btn btn-secondary btn-sm me-2">
                            <i class="bi bi-mortarboard-fill me-1"></i> {{ __("Graduación/Titulación") }}
                        </a>
                        <a href="{{ route("students.edit", $student->id) }}" class="btn btn-warning btn-sm me-2">
                            {{ __("Editar") }}
                        </a>
                        <a href="{{ route("students.index") }}" class="btn btn-secondary btn-sm">
                            {{ __("Volver") }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th class="w-30">{{ __("Nombre Completo") }}</th>
                                    <td>{{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Código de Estudiante") }}</th>
                                    <td>{{ $student->student_code ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Documento de Identidad") }}</th>
                                    <td>{{ $student->document_number }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Programas de Estudio / Carreras") }}</th>
                                    <td>
                                        @forelse ($student->careers as $career)
                                             <span class="badge border border-secondary text-reset mb-1 p-2">
                                                 <a href="{{ route("careers.show", $career->id) }}" class="text-decoration-none text-reset">
                                                     {{ $career->name }}
                                                    @if($career->pivot->shift)
                                                        ({{ $career->pivot->shift }})
                                                    @endif
                                                    @if($career->pivot->entry_year)
                                                        [{{ $career->pivot->entry_year }}{{ $career->pivot->graduation_year ? ' - ' . $career->pivot->graduation_year : '' }}]
                                                    @endif
                                                    @if($career->pivot->curriculum_id && isset($curriculums) && $curriculums->has($career->pivot->curriculum_id))
                                                        <span class="ms-1">| Malla: {{ $curriculums->get($career->pivot->curriculum_id)->name }}</span>
                                                    @endif
                                                    @if($career->pivot->title_date)
                                                        <small class="ms-1">({{ __('Titulado:') }} {{ \Carbon\Carbon::parse($career->pivot->title_date)->format('d/m/Y') }})</small>
                                                    @endif
                                                </a>
                                            </span>
                                        @empty
                                            <span>{{ __("Sin asignar") }}</span>
                                        @endforelse
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __("Correo Personal") }}</th>
                                    <td>{{ $student->personal_email ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Correo Institucional") }}</th>
                                    <td>{{ $student->institutional_email ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Teléfono") }}</th>
                                    <td>{{ $student->phone ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("WhatsApp") }}</th>
                                    <td>{{ $student->whatsapp ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Estado") }}</th>
                                    <td>
                                        @if ($student->status === "matriculado")
                                            <span class="badge bg-success">{{ __("Matriculado") }}</span>
                                        @elseif ($student->status === "egresado")
                                            <span class="badge bg-primary">{{ __("Egresado") }}</span>
                                        @elseif ($student->status === "retirado")
                                            <span class="badge bg-danger">{{ __("Retirado") }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $student->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Fecha de Matrícula") }}</th>
                                    <td>{{ $student->enrollment_date }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Año de Ingreso") }}</th>
                                    <td>{{ $student->entry_year }}</td>
                                </tr>
                                @if ($student->status === "egresado")
                                    <tr>
                                        <th>{{ __("Fecha de Titulación") }}</th>
                                        <td>{{ $student->graduation_date ? \Carbon\Carbon::parse($student->graduation_date)->format('d/m/Y') : __("No registrada") }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __("Año de Egreso") }}</th>
                                        <td>{{ $student->graduation_year ?? __("No registrado") }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>{{ __("Creado el") }}</th>
                                    <td>{{ $student->created_at->format("d/m/Y H:i") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Última actualización") }}</th>
                                    <td>{{ $student->updated_at->format("d/m/Y H:i") }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if ($student->job)
                <!-- Información Laboral -->
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0"><i class="bi bi-briefcase-fill me-2"></i>{{ __("Información Laboral (Titulados)") }}</span>
                            <a href="{{ route("students.graduation.edit", $student->id) }}" class="btn btn-outline-secondary btn-sm fw-bold">
                                <i class="bi bi-mortarboard-fill"></i> {{ __("Gestionar Titulación") }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th class="w-30">{{ __("Trabajo Actual") }}</th>
                                        <td>{{ $student->job->current_job ?? __("No registrado") }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __("Lugar (Empresa/Institución)") }}</th>
                                        <td>{{ $student->job->workplace ?? __("No registrado") }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __("Es de la carrera que estudió") }}</th>
                                        <td>
                                            @if ($student->job->is_related)
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>{{ __("Sí") }}</span>
                                            @else
                                                <span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i>{{ __("No") }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Historial Académico de Cursos -->
            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">{{ __("Historial Académico (Cursos)") }}</span>
                        <a href="{{ route("students.courses.edit", $student->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i> {{ __("Gestionar Cursos") }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session("success"))
                         <div class="alert alert-success" role="alert">
                             {{ session("success") }}
                         </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($student->careers->isEmpty())
                        <div class="alert alert-info text-center py-4 mb-0">
                            {{ __("No hay carreras asignadas a este estudiante.") }}
                        </div>
                    @else
                        @foreach ($student->careers as $career)
                            @php
                                $studentCurriculumId = $career->pivot->curriculum_id;
                                $curriculumName = $studentCurriculumId && isset($curriculums) && $curriculums->has($studentCurriculumId) 
                                    ? $curriculums->get($studentCurriculumId)->name 
                                    : __('Sin asignar');
                                // Regular courses of the student's assigned curriculum
                                $regularCareerCourses = $career->courses->where('curriculum_id', $studentCurriculumId)->where('is_actualizacion', false);
                                
                                // Courses registered by the student for this career (regular curriculum courses only)
                                $registeredRegularCourses = $student->courses->where('career_id', $career->id)->filter(function($course) use ($regularCareerCourses) {
                                    return $regularCareerCourses->pluck('id')->contains($course->id);
                                });
                                
                                // Update/Transition courses registered by the student for this career (where is_actualizacion = true)
                                $registeredUpdateCourses = $student->courses->where('career_id', $career->id)->where('is_actualizacion', true);
                            @endphp
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                                    <span class="fw-bold text-uppercase small">{{ $career->name }} (Malla: {{ $curriculumName }})</span>
                                    <span class="badge border border-secondary text-reset small">{{ $registeredRegularCourses->count() }} / {{ $regularCareerCourses->count() }} {{ $regularCareerCourses->count() == 1 ? 'curso' : 'cursos' }}</span>
                                </div>
                                @if ($regularCareerCourses->isEmpty())
                                    <div class="small ps-2 py-2">{{ __("No hay cursos definidos para esta malla curricular.") }}</div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>{{ __("Código") }}</th>
                                                    <th>{{ __("Curso") }}</th>
                                                    <th>{{ __("Créditos") }}</th>
                                                    <th>{{ __("Nota") }}</th>
                                                    <th>{{ __("Estado") }}</th>
                                                    <th class="text-center">{{ __("Acciones") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($regularCareerCourses as $course)
                                                    @php
                                                        $registeredCourse = $student->courses->firstWhere('id', $course->id);
                                                    @endphp
                                                    @if ($registeredCourse)
                                                        <tr>
                                                            <td><strong>{{ $registeredCourse->code }}</strong></td>
                                                            <td>{{ $registeredCourse->name }}</td>
                                                            <td>{{ $registeredCourse->credits }}</td>
                                                            <td>{{ $registeredCourse->pivot->grade ?? __("N/A") }}</td>
                                                            <td>
                                                                @if ($registeredCourse->pivot->status === "aprobado")
                                                                    <span class="badge bg-success">{{ __("Aprobado") }}</span>
                                                                @else
                                                                    <span class="badge bg-danger">{{ __("Desaprobado") }}</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route("students.courses.edit", [$student->id, 'edit_course_id' => $registeredCourse->id]) }}" class="btn btn-warning btn-sm">
                                                                    <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td><strong>{{ $course->code }}</strong></td>
                                                            <td>{{ $course->name }}</td>
                                                            <td>{{ $course->credits }}</td>
                                                            <td class="text-center">-</td>
                                                            <td>
                                                                <span class="badge bg-secondary">{{ __("Pendiente") }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route("students.courses.edit", [$student->id, 'select_course_id' => $course->id]) }}" class="btn btn-primary btn-sm">
                                                                    <i class="bi bi-plus-lg"></i> {{ __("Registrar") }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if ($registeredUpdateCourses->isNotEmpty())
                                    <div class="mt-3 border p-2 rounded">
                                        <div class="fw-bold small text-uppercase mb-2"><i class="bi bi-arrow-repeat me-1"></i>{{ __("Cursos de Actualización Registrados") }}</div>
                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __("Código") }}</th>
                                                        <th>{{ __("Curso") }}</th>
                                                        <th>{{ __("Créditos") }}</th>
                                                        <th>{{ __("Nota") }}</th>
                                                        <th>{{ __("Estado") }}</th>
                                                        <th class="text-center">{{ __("Acciones") }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($registeredUpdateCourses as $course)
                                                        <tr>
                                                            <td><strong>{{ $course->code }}</strong></td>
                                                            <td>{{ $course->name }}</td>
                                                            <td>{{ $course->credits }}</td>
                                                            <td>{{ $course->pivot->grade ?? __("N/A") }}</td>
                                                            <td>
                                                                @if ($course->pivot->status === "aprobado")
                                                                    <span class="badge bg-success">{{ __("Aprobado") }}</span>
                                                                @else
                                                                    <span class="badge bg-danger">{{ __("Desaprobado") }}</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route("students.courses.edit", [$student->id, 'edit_course_id' => $course->id]) }}" class="btn btn-warning btn-sm">
                                                                    <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        @php
                            $careerIds = $student->careers->pluck('id')->toArray();
                            $otherCourses = $student->courses->filter(function($course) use ($careerIds) {
                                return !in_array($course->career_id, $careerIds);
                            });
                        @endphp
                        @if ($otherCourses->isNotEmpty())
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                                    <span class="fw-bold text-uppercase small">{{ __("Otros Cursos (Sin Carrera Activa)") }}</span>
                                    <span class="badge bg-warning small">{{ $otherCourses->count() }} {{ $otherCourses->count() == 1 ? 'curso' : 'cursos' }}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __("Código") }}</th>
                                                <th>{{ __("Curso") }}</th>
                                                <th>{{ __("Créditos") }}</th>
                                                <th>{{ __("Nota") }}</th>
                                                <th>{{ __("Estado") }}</th>
                                                <th class="text-center">{{ __("Acciones") }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($otherCourses as $course)
                                                <tr>
                                                    <td><strong>{{ $course->code }}</strong></td>
                                                    <td>{{ $course->name }}</td>
                                                    <td>{{ $course->credits }}</td>
                                                    <td>{{ $course->pivot->grade ?? __("N/A") }}</td>
                                                    <td>
                                                        @if ($course->pivot->status === "aprobado")
                                                            <span class="badge bg-success">{{ __("Aprobado") }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ __("Desaprobado") }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route("students.courses.edit", [$student->id, 'edit_course_id' => $course->id]) }}" class="btn btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Módulos EFSRT -->
            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">{{ __("Módulos EFSRT (Experiencias Formativas)") }}</span>
                        <a href="{{ route("students.efsrt.edit", $student->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i> {{ __("Gestionar EFSRT") }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($student->careers->isEmpty())
                        <div class="alert alert-info text-center py-4 mb-0">
                            {{ __("No hay carreras asignadas a este estudiante.") }}
                        </div>
                    @else
                        @foreach ($student->careers as $career)
                            @php
                                $careerEfsrt = $student->efsrtRecords->where('career_id', $career->id);
                            @endphp
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                                    <span class="fw-bold text-uppercase small">{{ $career->name }}</span>
                                    <span class="badge bg-secondary small">{{ $careerEfsrt->where('status', 'aprobado')->count() }} / {{ $careerEfsrt->count() }} {{ __("módulos aprobados") }}</span>
                                </div>
                                @if ($careerEfsrt->isEmpty())
                                    <div class="small ps-2 py-2">{{ __("No hay registros EFSRT para esta carrera.") }}</div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>{{ __("Módulo") }}</th>
                                                    <th>{{ __("Empresa") }}</th>
                                                    <th>{{ __("Horas") }}</th>
                                                    <th>{{ __("Nota") }}</th>
                                                    <th>{{ __("Estado") }}</th>
                                                    <th class="text-center">{{ __("Acciones") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($careerEfsrt as $efsrt)
                                                    <tr>
                                                        <td><strong>{{ $efsrt->module_name }}</strong></td>
                                                        <td>{{ $efsrt->company ?? __("No registrada") }}</td>
                                                        <td>{{ $efsrt->hours ? $efsrt->hours . " hrs" : __("N/A") }}</td>
                                                        <td>{{ $efsrt->grade ?? __("N/A") }}</td>
                                                        <td>
                                                            @if ($efsrt->status === "aprobado")
                                                                <span class="badge bg-success">{{ __("Aprobado") }}</span>
                                                            @elseif ($efsrt->status === "desaprobado")
                                                                <span class="badge bg-danger">{{ __("Desaprobado") }}</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ __("Pendiente") }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route("students.efsrt.edit", $student->id) }}" class="btn btn-warning btn-sm">
                                                                <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        @php
                            $careerIds = $student->careers->pluck('id')->toArray();
                            $otherEfsrt = $student->efsrtRecords->filter(function($record) use ($careerIds) {
                                return !in_array($record->career_id, $careerIds);
                            });
                        @endphp
                        @if ($otherEfsrt->isNotEmpty())
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                                    <span class="fw-bold text-uppercase small">{{ __("Otros Módulos EFSRT (Sin Carrera Activa)") }}</span>
                                    <span class="badge bg-warning small">{{ $otherEfsrt->where('status', 'aprobado')->count() }} / {{ $otherEfsrt->count() }} {{ __("módulos aprobados") }}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{ __("Módulo") }}</th>
                                                <th>{{ __("Empresa") }}</th>
                                                <th>{{ __("Horas") }}</th>
                                                <th>{{ __("Nota") }}</th>
                                                <th>{{ __("Estado") }}</th>
                                                <th class="text-center">{{ __("Acciones") }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($otherEfsrt as $efsrt)
                                                <tr>
                                                    <td><strong>{{ $efsrt->module_name }}</strong></td>
                                                    <td>{{ $efsrt->company ?? __("No registrada") }}</td>
                                                    <td>{{ $efsrt->hours ? $efsrt->hours . " hrs" : __("N/A") }}</td>
                                                    <td>{{ $efsrt->grade ?? __("N/A") }}</td>
                                                    <td>
                                                        @if ($efsrt->status === "aprobado")
                                                            <span class="badge bg-success">{{ __("Aprobado") }}</span>
                                                        @elseif ($efsrt->status === "desaprobado")
                                                            <span class="badge bg-danger">{{ __("Desaprobado") }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ __("Pendiente") }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route("students.efsrt.edit", $student->id) }}" class="btn btn-warning btn-sm">
                                                            <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

</div>
@endsection
