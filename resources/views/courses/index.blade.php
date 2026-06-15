@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Gestión de Cursos") }}</span>
                    <a href="{{ route("courses.create") }}" class="btn btn-primary btn-sm">
                        {{ __("Registrar Curso") }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session("success"))
                         <div class="alert alert-success" role="alert">
                             {{ session("success") }}
                         </div>
                    @endif

                    <!-- Filtro por Carrera professional -->
                    <div class="mb-4">
                        <form method="GET" action="{{ route("courses.index") }}" class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="career_id" class="col-form-label">{{ __("Filtrar por Carrera:") }}</label>
                            </div>
                            <div class="col-auto">
                                <select name="career_id" id="career_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">{{ __("Todas las Carreras") }}</option>
                                    @foreach ($careers as $career)
                                        <option value="{{ $career->id }}" {{ $careerId == $career->id ? "selected" : "" }}>
                                            {{ $career->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                             <thead>
                                 <tr>
                                     <th>{{ __("Código") }}</th>
                                    <th>{{ __("Nombre del Curso") }}</th>
                                    <th>{{ __("Créditos") }}</th>
                                    <th>{{ __("Carrera Profesional") }}</th>
                                    <th class="text-center">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $course)
                                    <tr>
                                        <td><strong>{{ $course->code }}</strong></td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->credits }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $course->career->name }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                 <a href="{{ route("courses.edit", $course->id) }}" class="btn btn-warning btn-sm" title="{{ __("Editar") }}">
                                                     <i class="bi bi-pencil">{{ __("Editar") }}</i>
                                                 </a>
                                                <form action="{{ route("courses.destroy", $course->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso?');">
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
                                             {{ __("No se encontraron cursos registrados.") }}
                                         </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
