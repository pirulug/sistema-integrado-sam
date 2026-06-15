@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row">
        <!-- Form Column (Left) -->
        <div class="col-md-4">
            @if ($editingCourse)
                <!-- Edit Course Grade & Status Card -->
                <div class="card mb-3">
                    <div class="card-header bg-warning text-white">
                        <span class="h6 mb-0">{{ __("Editar Nota de Curso") }}</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __("Curso") }}</label>
                            <div>{{ $editingCourse->code }} - {{ $editingCourse->name }}</div>
                            <small class="text-muted">({{ $editingCourse->credits }} {{ __("créditos") }})</small>
                        </div>

                        <form method="POST" action="{{ route("students.courses.update", [$student->id, $editingCourse->id]) }}">
                            @csrf
                            @method("PUT")

                            <div class="mb-3">
                                <label for="grade" class="form-label">{{ __("Nota (0-20)") }}</label>
                                <input type="number" class="form-control" id="grade" name="grade" 
                                       value="{{ old("grade", $editingCourse->pivot->grade) }}" min="0" max="20">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __("Estado") }} *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="aprobado" {{ old("status", $editingCourse->pivot->status) === "aprobado" ? "selected" : "" }}>{{ __("Aprobado") }}</option>
                                    <option value="desaprobado" {{ old("status", $editingCourse->pivot->status) === "desaprobado" ? "selected" : "" }}>{{ __("Desaprobado") }}</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning text-white">{{ __("Actualizar Nota") }}</button>
                                <a href="{{ route("students.courses.edit", $student->id) }}" class="btn btn-secondary">
                                    {{ __("Cancelar") }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <!-- Register New Course Card -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <span class="h6 mb-0">{{ __("Registrar Curso") }}</span>
                    </div>
                    <div class="card-body">
                        @if ($availableCourses->isEmpty())
                            <div class="alert alert-warning mb-0">
                                {{ __("No hay cursos disponibles para registrar.") }}
                            </div>
                        @else
                            <form method="POST" action="{{ route("students.courses.store", $student->id) }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="course_id" class="form-label">{{ __("Curso") }} *</label>
                                    <select class="form-select" id="course_id" name="course_id" required>
                                        <option value="">{{ __("Seleccione un curso...") }}</option>
                                        @foreach ($availableCourses as $c)
                                            <option value="{{ $c->id }}" {{ old("course_id") == $c->id ? "selected" : "" }}>
                                                {{ $c->code }} - {{ $c->name }} ({{ $c->credits }} cr)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="grade" class="form-label">{{ __("Nota (0-20)") }}</label>
                                    <input type="number" class="form-control" id="grade" name="grade" 
                                           value="{{ old("grade") }}" min="0" max="20" placeholder="e.g. 14">
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">{{ __("Estado") }} *</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="aprobado" selected>{{ __("Aprobado") }}</option>
                                        <option value="desaprobado">{{ __("Desaprobado") }}</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">{{ __("Registrar") }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- History Column (Right) -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Historial Académico") }} - {{ $student->name }}</span>
                    <a href="{{ route("students.show", $student->id) }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session("success"))
                         <div class="alert alert-success" role="alert">
                             {{ session("success") }}
                         </div>
                    @endif

                    @if ($errors->any() && !$editingCourse)
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
                                    <th class="text-center">{{ __("Créditos") }}</th>
                                    <th class="text-center">{{ __("Nota") }}</th>
                                    <th>{{ __("Estado") }}</th>
                                    <th class="text-center">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($student->courses as $course)
                                    <tr class="{{ ($editingCourse && $editingCourse->id === $course->id) ? "table-warning" : "" }}">
                                        <td><strong>{{ $course->code }}</strong></td>
                                        <td>{{ $course->name }}</td>
                                        <td class="text-center">{{ $course->credits }}</td>
                                        <td class="text-center fw-bold">{{ $course->pivot->grade ?? __("N/A") }}</td>
                                        <td>
                                            @if ($course->pivot->status === "aprobado")
                                                <span class="badge bg-success">{{ __("Aprobado") }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __("Desaprobado") }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route("students.courses.edit", [$student->id, 'edit_course_id' => $course->id]) }}" 
                                                   class="btn btn-warning btn-sm text-white" title="{{ __("Editar") }}">
                                                    {{ __("Editar") }}
                                                </a>
                                                
                                                <form action="{{ route("students.courses.destroy", [$student->id, $course->id]) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso del historial?');">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __("Eliminar") }}">
                                                        {{ __("Eliminar") }}
                                                    </button>
                                                </form>
                                            </div>
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
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const gradeInput = document.getElementById("grade");
        const statusSelect = document.getElementById("status");
        if (gradeInput && statusSelect) {
            gradeInput.addEventListener("input", function () {
                const val = parseInt(gradeInput.value);
                if (!isNaN(val)) {
                    if (val >= 11) {
                        statusSelect.value = "aprobado";
                    } else {
                        statusSelect.value = "desaprobado";
                    }
                }
            });
        }
    });
</script>
@endsection
