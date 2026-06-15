@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Gestión de Programas de Estudio / Carreras") }}</span>
                    <a href="{{ route("careers.create") }}" class="btn btn-primary btn-sm">
                        {{ __("Registrar Carrera") }}
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
                            <a href="{{ route("careers.index", ["status" => "todos"]) }}" 
                               class="btn btn-sm {{ !$status || $status === "todos" ? "btn-secondary" : "btn-outline-secondary" }}">
                                {{ __("Todos") }}
                            </a>
                            <a href="{{ route("careers.index", ["status" => "activo"]) }}" 
                               class="btn btn-sm {{ $status === "activo" ? "btn-success" : "btn-outline-success" }}">
                                {{ __("Activos") }}
                            </a>
                            <a href="{{ route("careers.index", ["status" => "inactivo"]) }}" 
                               class="btn btn-sm {{ $status === "inactivo" ? "btn-danger" : "btn-outline-danger" }}">
                                {{ __("Inactivos") }}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                             <thead>
                                 <tr>
                                     <th>{{ __("Código") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Descripción") }}</th>
                                    <th>{{ __("Estado") }}</th>
                                    <th class="text-center">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($careers as $career)
                                    <tr>
                                        <td>{{ $career->code ?? __("N/A") }}</td>
                                        <td><strong>{{ $career->name }}</strong></td>
                                        <td>{{ Str::limit($career->description, 60) ?? __("Sin descripción") }}</td>
                                        <td>
                                            @if ($career->status === "activo")
                                                <span class="badge bg-success">{{ __("Activo") }}</span>
                                            @elseif ($career->status === "inactivo")
                                                <span class="badge bg-danger">{{ __("Inactivo") }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $career->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                 <a href="{{ route("careers.show", $career->id) }}" class="btn btn-info btn-sm" title="{{ __("Ver") }}">
                                                     <i class="bi bi-eye">{{ __("Ver") }}</i>
                                                 </a>
                                                 <a href="{{ route("careers.edit", $career->id) }}" class="btn btn-warning btn-sm" title="{{ __("Editar") }}">
                                                     <i class="bi bi-pencil">{{ __("Editar") }}</i>
                                                 </a>
                                                <form action="{{ route("careers.destroy", $career->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este programa de estudio? Se desvinculará de los estudiantes asociados.');">
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
                                         <td colspan="5" class="text-center py-4">
                                             {{ __("No se encontraron programas de estudio registrados.") }}
                                         </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $careers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
