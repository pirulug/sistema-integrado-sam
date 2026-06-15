@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Editar Módulos EFSRT") }}</span>
                    <a href="{{ route("students.show", $student->id) }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>{{ __("Estudiante:") }}</strong> {{ $student->name }} ({{ $student->document_number }})
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route("students.efsrt.updateAll", $student->id) }}">
                        @csrf
                        @method("PUT")

                        @php
                            $groupedEfsrt = $student->efsrtRecords->groupBy('career_id');
                        @endphp
                        @foreach ($groupedEfsrt as $careerId => $records)
                            @php
                                $career = $records->first()->career;
                            @endphp
                            <h5 class="mt-4 mb-3 fw-bold" style="font-size: 1.1rem;">{{ $career ? $career->name : 'General' }}</h5>
                            @foreach ($records as $efsrt)
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0 fw-bold text-body">{{ $efsrt->module_name }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="company_{{ $efsrt->id }}" class="form-label">{{ __("Empresa") }}</label>
                                                <input type="text" class="form-control" id="company_{{ $efsrt->id }}" 
                                                       name="efsrt[{{ $efsrt->id }}][company]" value="{{ old('efsrt.' . $efsrt->id . '.company', $efsrt->company) }}">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="hours_{{ $efsrt->id }}" class="form-label">{{ __("Horas") }}</label>
                                                <input type="number" class="form-control" id="hours_{{ $efsrt->id }}" 
                                                       name="efsrt[{{ $efsrt->id }}][hours]" value="{{ old('efsrt.' . $efsrt->id . '.hours', $efsrt->hours) }}" min="0">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="grade_efsrt_{{ $efsrt->id }}" class="form-label">{{ __("Nota") }}</label>
                                                <input type="number" class="form-control" id="grade_efsrt_{{ $efsrt->id }}" 
                                                       name="efsrt[{{ $efsrt->id }}][grade]" value="{{ old('efsrt.' . $efsrt->id . '.grade', $efsrt->grade) }}" min="0" max="20">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="status_efsrt_{{ $efsrt->id }}" class="form-label">{{ __("Estado") }} *</label>
                                                <select class="form-select" id="status_efsrt_{{ $efsrt->id }}" 
                                                        name="efsrt[{{ $efsrt->id }}][status]" required>
                                                    <option value="pendiente" {{ old('efsrt.' . $efsrt->id . '.status', $efsrt->status) === 'pendiente' ? 'selected' : '' }}>{{ __("Pendiente") }}</option>
                                                    <option value="aprobado" {{ old('efsrt.' . $efsrt->id . '.status', $efsrt->status) === 'aprobado' ? 'selected' : '' }}>{{ __("Aprobado") }}</option>
                                                    <option value="desaprobado" {{ old('efsrt.' . $efsrt->id . '.status', $efsrt->status) === 'desaprobado' ? 'selected' : '' }}>{{ __("Desaprobado") }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach

                        <div class="text-end mt-3">
                            <a href="{{ route("students.show", $student->id) }}" class="btn btn-secondary">{{ __("Cancelar") }}</a>
                            <button type="submit" class="btn btn-primary">
                                {{ __("Guardar Cambios") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @foreach ($student->efsrtRecords as $efsrt)
            (function() {
                const gradeInput = document.getElementById("grade_efsrt_{{ $efsrt->id }}");
                const statusSelect = document.getElementById("status_efsrt_{{ $efsrt->id }}");
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
            })();
        @endforeach
    });
</script>
@endsection
