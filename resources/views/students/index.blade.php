@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Gestión de Estudiantes") }}</span>
                    <a href="{{ route("students.create") }}" class="btn btn-primary btn-sm">
                        {{ __("Registrar Estudiante") }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session("success"))
                        <div class="alert alert-success" role="alert">
                            {{ session("success") }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <span class="me-2">{{ __("Filtrar por estado:") }}</span>
                        <div class="btn-group" role="group">
                            <a href="{{ route("students.index", ["status" => "todos"]) }}" 
                               class="btn btn-sm {{ !$status || $status === "todos" ? "btn-secondary" : "btn-outline-secondary" }}">
                                {{ __("Todos") }}
                            </a>
                            <a href="{{ route("students.index", ["status" => "matriculado"]) }}" 
                               class="btn btn-sm {{ $status === "matriculado" ? "btn-success text-white" : "btn-outline-success" }}">
                                {{ __("Matriculados") }}
                            </a>
                            <a href="{{ route("students.index", ["status" => "egresado"]) }}" 
                               class="btn btn-sm {{ $status === "egresado" ? "btn-primary" : "btn-outline-primary" }}">
                                {{ __("Egresados") }}
                            </a>
                            <a href="{{ route("students.index", ["status" => "retirado"]) }}" 
                               class="btn btn-sm {{ $status === "retirado" ? "btn-danger text-white" : "btn-outline-danger" }}">
                                {{ __("Retirados") }}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __("Documento") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Carrera") }}</th>
                                    <th>{{ __("Email") }}</th>
                                    <th>{{ __("Teléfono") }}</th>
                                    <th>{{ __("Estado") }}</th>
                                    <th>{{ __("Matrícula") }}</th>
                                    <th class="text-center">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <td>{{ $student->document_number }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            @forelse ($student->careers as $career)
                                                <span class="badge bg-secondary mb-1" style="font-size: 0.8rem;">{{ $career->name }}</span>
                                            @empty
                                                <span class="text-muted">{{ __("Sin asignar") }}</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $student->email ?? __("N/A") }}</td>
                                        <td>{{ $student->phone ?? __("N/A") }}</td>
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
                                        <td>{{ $student->enrollment_date }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route("students.show", $student->id) }}" class="btn btn-info btn-sm text-white" title="{{ __("Ver") }}">
                                                    <i class="bi bi-eye">{{ __("Ver") }}</i>
                                                </a>
                                                <a href="{{ route("students.edit", $student->id) }}" class="btn btn-warning btn-sm text-white" title="{{ __("Editar") }}">
                                                    <i class="bi bi-pencil">{{ __("Editar") }}</i>
                                                </a>
                                                <form action="{{ route("students.destroy", $student->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este estudiante?');">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __("Eliminar") }}">
                                                        <i class="bi bi-trash">{{ __("Eliminar") }}</i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            {{ __("No se encontraron estudiantes registrados.") }}
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
