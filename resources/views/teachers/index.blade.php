@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Gestión de Profesores") }}</span>
                    <a href="{{ route("teachers.create") }}" class="btn btn-primary btn-sm">
                        {{ __("Registrar Profesor") }}
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
                            <a href="{{ route("teachers.index", ["status" => "todos"]) }}" 
                               class="btn btn-sm {{ !$status || $status === "todos" ? "btn-secondary" : "btn-outline-secondary" }}">
                                {{ __("Todos") }}
                            </a>
                            <a href="{{ route("teachers.index", ["status" => "activo"]) }}" 
                               class="btn btn-sm {{ $status === "activo" ? "btn-success text-white" : "btn-outline-success" }}">
                                {{ __("Activos") }}
                            </a>
                            <a href="{{ route("teachers.index", ["status" => "inactivo"]) }}" 
                               class="btn btn-sm {{ $status === "inactivo" ? "btn-danger text-white" : "btn-outline-danger" }}">
                                {{ __("Inactivos") }}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __("Documento") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Email") }}</th>
                                    <th>{{ __("Teléfono") }}</th>
                                    <th>{{ __("Especialidad") }}</th>
                                    <th>{{ __("Estado") }}</th>
                                    <th>{{ __("Contratación") }}</th>
                                    <th class="text-center">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->document_number }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email ?? __("N/A") }}</td>
                                        <td>{{ $teacher->phone ?? __("N/A") }}</td>
                                        <td>{{ $teacher->specialty }}</td>
                                        <td>
                                            @if ($teacher->status === "activo")
                                                <span class="badge bg-success">{{ __("Activo") }}</span>
                                            @elseif ($teacher->status === "inactivo")
                                                <span class="badge bg-danger">{{ __("Inactivo") }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $teacher->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $teacher->hire_date }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route("teachers.show", $teacher->id) }}" class="btn btn-info btn-sm text-white" title="{{ __("Ver") }}">
                                                    <i class="bi bi-eye">{{ __("Ver") }}</i>
                                                </a>
                                                <a href="{{ route("teachers.edit", $teacher->id) }}" class="btn btn-warning btn-sm text-white" title="{{ __("Editar") }}">
                                                    <i class="bi bi-pencil">{{ __("Editar") }}</i>
                                                </a>
                                                <form action="{{ route("teachers.destroy", $teacher->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este profesor?');">
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
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            {{ __("No se encontraron profesores registrados.") }}
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
        </div>
    </div>
</div>
@endsection
