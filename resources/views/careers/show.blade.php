@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Detalle de la Carrera -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">{{ __("Detalle del Programa de Estudio") }}</span>
                        <div>
                            <a href="{{ route("careers.edit", $career->id) }}" class="btn btn-warning btn-sm me-1">
                                {{ __("Editar") }}
                            </a>
                            <a href="{{ route("careers.index") }}" class="btn btn-secondary btn-sm">
                                {{ __("Volver") }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="w-25">{{ __("Nombre") }}</th>
                                <td><strong>{{ $career->name }}</strong></td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __("Código / Sigla") }}</th>
                                <td>{{ $career->code ?? __("N/A") }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __("Descripción") }}</th>
                                <td>{{ $career->description ?? __("Sin descripción") }}</td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __("Estado") }}</th>
                                <td>
                                    @if ($career->status === "activo")
                                        <span class="badge bg-success">{{ __("Activo") }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __("Inactivo") }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __("Turnos Disponibles") }}</th>
                                <td>
                                    @if (!empty($career->shifts))
                                        @foreach ($career->shifts as $shift)
                                            <span class="badge bg-secondary me-1">{{ $shift }}</span>
                                        @endforeach
                                    @else
                                        <span>{{ __("Sin turnos asignados") }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __("Fecha de Registro") }}</th>
                                <td>{{ $career->created_at->format("d/m/Y H:i") }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Profesores Asignados -->
            <div class="card mb-4">
                <div class="card-header">
                    <span class="h5 mb-0">{{ __("Profesores Nombrados / Asignados") }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __("Documento") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Email") }}</th>
                                    <th>{{ __("Especialidad") }}</th>
                                    <th>{{ __("Estado") }}</th>
                                    <th class="text-center">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->document_number }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email ?? __("N/A") }}</td>
                                        <td>{{ $teacher->specialty }}</td>
                                        <td>
                                            @if ($teacher->status === "activo")
                                                <span class="badge bg-success">{{ __("Activo") }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __("Inactivo") }}</span>
                                            @endif
                                        </td>
                                         <td class="text-center">
                                             <a href="{{ route("teachers.show", $teacher->id) }}" class="btn btn-info btn-sm">
                                                 {{ __("Ver Profesor") }}
                                             </a>
                                         </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            {{ __("No hay profesores asignados a esta carrera.") }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $teachers->links() }}
                    </div>
                </div>
            </div>

            <!-- Estudiantes Inscritos -->
            <div class="card">
                <div class="card-header">
                    <span class="h5 mb-0">{{ __("Estudiantes Inscritos") }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __("Documento") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Email") }}</th>
                                    <th>{{ __("Teléfono") }}</th>
                                    <th>{{ __("Turno") }}</th>
                                    <th>{{ __("Estado") }}</th>
                                    <th class="text-center">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <td>{{ $student->document_number }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->institutional_email ?? $student->personal_email ?? __("N/A") }}</td>
                                        <td>{{ $student->phone ?? __("N/A") }}</td>
                                         <td>
                                             @if ($student->pivot->shift)
                                                 <span class="badge bg-info">{{ $student->pivot->shift }}</span>
                                             @else
                                                 <span>{{ __("N/A") }}</span>
                                             @endif
                                         </td>
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
                                         <td class="text-center">
                                             <a href="{{ route("students.show", $student->id) }}" class="btn btn-info btn-sm">
                                                 {{ __("Ver Estudiante") }}
                                             </a>
                                         </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            {{ __("No hay estudiantes inscritos en esta carrera.") }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
