@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Gestión de Mallas Curriculares") }}</span>
                    <a href="{{ route("curriculums.create") }}" class="btn btn-primary btn-sm">
                        {{ __("Registrar Malla") }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session("success"))
                         <div class="alert alert-success" role="alert">
                             {{ session("success") }}
                         </div>
                    @endif

                    <!-- Filtro por Carrera -->
                    <div class="mb-4">
                        <form method="GET" action="{{ route("curriculums.index") }}" class="row g-3 align-items-center">
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
                                     <th>{{ __("Nombre de Malla") }}</th>
                                     <th>{{ __("Año de Malla") }}</th>
                                     <th>{{ __("Carrera Profesional") }}</th>
                                     <th>{{ __("Cursos Asociados") }}</th>
                                     <th class="text-center">{{ __("Acciones") }}</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @forelse ($curriculums as $curr)
                                     <tr>
                                         <td><strong>{{ $curr->name }}</strong></td>
                                         <td>{{ $curr->year }}</td>
                                         <td>
                                             <span class="badge bg-secondary">{{ $curr->career->name }}</span>
                                         </td>
                                         <td>
                                             <span class="badge border border-secondary text-reset">{{ $curr->courses->count() }} {{ $curr->courses->count() == 1 ? 'curso' : 'cursos' }}</span>
                                         </td>
                                         <td class="text-center">
                                             <div class="btn-group" role="group">
                                                  <a href="{{ route("curriculums.show", $curr->id) }}" class="btn btn-info btn-sm" title="{{ __("Ver Estructura") }}">
                                                      <i class="bi bi-eye"></i> {{ __("Ver") }}
                                                  </a>
                                                  <a href="{{ route("curriculums.edit", $curr->id) }}" class="btn btn-warning btn-sm" title="{{ __("Editar") }}">
                                                      <i class="bi bi-pencil"></i> {{ __("Editar") }}
                                                  </a>
                                                 <form action="{{ route("curriculums.destroy", $curr->id) }}" method="POST" class="d-inline"
                                                       onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta malla curricular? Esto eliminará todos los cursos asociados a ella.');">
                                                     @csrf
                                                     @method("DELETE")
                                                     <button type="submit" class="btn btn-danger btn-sm" title="{{ __("Eliminar") }}">
                                                         <i class="bi bi-trash"></i> {{ __("Eliminar") }}
                                                     </button>
                                                 </form>
                                             </div>
                                         </td>
                                     </tr>
                                 @empty
                                     <tr>
                                          <td colspan="5" class="text-center py-4">
                                              {{ __("No se encontraron mallas curriculares registradas.") }}
                                          </td>
                                     </tr>
                                 @endforelse
                             </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $curriculums->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
