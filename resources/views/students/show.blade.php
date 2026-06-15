@extends("layouts.app")

@section("content")
<div class="container">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Detalles del Estudiante") }}</span>
                    <div>
                        <a href="{{ route("students.edit", $student->id) }}" class="btn btn-warning btn-sm text-white me-2">
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
                                            <span class="badge bg-secondary mb-1 p-2">
                                                <a href="{{ route("careers.show", $career->id) }}" class="text-white text-decoration-none">
                                                    {{ $career->name }}
                                                    @if($career->pivot->shift)
                                                        ({{ $career->pivot->shift }})
                                                    @endif
                                                    @if($career->pivot->entry_year)
                                                        [{{ $career->pivot->entry_year }}{{ $career->pivot->graduation_year ? ' - ' . $career->pivot->graduation_year : '' }}]
                                                    @endif
                                                </a>
                                            </span>
                                        @empty
                                            <span class="text-muted">{{ __("Sin asignar") }}</span>
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Correo General") }}</th>
                                    <td>{{ $student->email ?? __("No registrado") }}</td>
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
                                        <th>{{ __("Fecha de Egreso") }}</th>
                                        <td>{{ $student->graduation_date ?? __("No registrada") }}</td>
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
                <div class="card mt-4 border-success">
                    <div class="card-header bg-success text-white py-3">
                        <span class="h5 mb-0"><i class="bi bi-briefcase-fill me-2"></i>{{ __("Información Laboral (Titulados)") }}</span>
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
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Historial Académico (Cursos)") }}</span>
                    <a href="{{ route("students.courses.edit", $student->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> {{ __("Gestionar Cursos") }}
                    </a>
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

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
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
                                @forelse ($student->courses as $course)
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
                                            <a href="{{ route("students.courses.edit", [$student->id, 'edit_course_id' => $course->id]) }}" class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            {{ __("No hay cursos registrados en el historial de este estudiante.") }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Módulos EFSRT -->
            <div class="card mt-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Módulos EFSRT (Experiencias Formativas)") }}</span>
                    <a href="{{ route("students.efsrt.edit", $student->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> {{ __("Gestionar EFSRT") }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
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
                                @forelse ($student->efsrtRecords as $efsrt)
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
                                            <a href="{{ route("students.efsrt.edit", $student->id) }}" class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            {{ __("No hay registros EFSRT asociados.") }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

</div>
@endsection
