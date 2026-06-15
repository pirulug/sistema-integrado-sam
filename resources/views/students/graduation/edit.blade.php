@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="small d-block mb-1 text-uppercase fw-bold">{{ __("Académico") }}</span>
                            <h5 class="mb-0 fw-bold"><i class="bi bi-mortarboard-fill me-2"></i>{{ __("Gestión de Titulación") }}</h5>
                        </div>
                        <a href="{{ route("students.show", $student->id) }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                            <i class="bi bi-arrow-left"></i> {{ __("Volver al Detalle") }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Student Summary -->
                    <div class="border p-3 rounded mb-4 d-flex align-items-center gap-3">
                        <div class="border rounded-circle px-3 py-2">
                            <i class="bi bi-person-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">{{ $student->name }}</h6>
                            <span class="small">
                                <i class="bi bi-person-vcard me-1"></i>DNI: {{ $student->document_number }} 
                                @if($student->student_code)
                                    <span class="mx-2">|</span>
                                    <i class="bi bi-code-square me-1"></i>Código: {{ $student->student_code }}
                                @endif
                            </span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger  mb-4">
                            <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __("Por favor, corrija los siguientes errores:") }}</h6>
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route("students.graduation.update", $student->id) }}">
                        @csrf
                        @method("PUT")

                        <h6 class="fw-bold  text-uppercase small mb-3  pb-2">{{ __("Programas de Estudio / Carreras Inscritas") }}</h6>

                        @foreach ($careersData as $data)
                            @php
                                $career = $data['career'];
                                $isEligible = $data['is_eligible'];
                                $pendingCourses = $data['pending_courses'];
                                $incompleteEfsrt = $data['incomplete_efsrt'];
                                $graduationYear = $data['graduation_year'];
                            @endphp

                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold small"><i class="bi bi-journal-text me-2"></i>{{ $career->name }}</span>
                                        @if ($isEligible)
                                            <span class="badge bg-success small fw-semibold">
                                                <i class="bi bi-check-circle-fill me-1"></i>{{ __("Elegible para Titulación") }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger small fw-semibold">
                                                <i class="bi bi-exclamation-circle-fill me-1"></i>{{ __("Requisitos Pendientes") }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Form Input Section -->
                                        <div class="col-md-5 col-sm-12 border-end pe-md-4">
                                            <div class="mb-2">
                                                <label for="graduation_year_{{ $career->id }}" class="form-label small fw-bold mb-1">
                                                    {{ __("Año de Graduación / Egreso") }}
                                                </label>
                                                <input type="number" 
                                                       name="career_graduation_years[{{ $career->id }}]" 
                                                       id="graduation_year_{{ $career->id }}" 
                                                       class="form-control career-grad-input @error('career_graduation_years.'.$career->id) is-invalid @enderror" 
                                                       value="{{ old('career_graduation_years.'.$career->id, $graduationYear) }}" 
                                                       min="1900" max="2100" 
                                                       placeholder="Ej: 2024"
                                                       {{ $isEligible ? '' : 'disabled' }}>
                                                @if (!$isEligible)
                                                    <input type="hidden" name="career_graduation_years[{{ $career->id }}]" value="">
                                                    <div class="form-text small mt-1">
                                                        <i class="bi bi-lock-fill me-1"></i>{{ __("Bloqueado debido a requisitos incompletos.") }}
                                                    </div>
                                                @else
                                                    <div class="form-text small mt-1">
                                                        {{ __("Deje en blanco si aún no se ha graduado.") }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-2 mt-3">
                                                <label for="title_date_{{ $career->id }}" class="form-label small fw-bold mb-1">
                                                    {{ __("Fecha de Titulación") }}
                                                </label>
                                                <input type="date" 
                                                       name="career_title_dates[{{ $career->id }}]" 
                                                       id="title_date_{{ $career->id }}" 
                                                       class="form-control career-title-date-input @error('career_title_dates.'.$career->id) is-invalid @enderror" 
                                                       value="{{ old('career_title_dates.'.$career->id, $data['title_date'] ?? '') }}" 
                                                       {{ $isEligible ? '' : 'disabled' }}>
                                                @if (!$isEligible)
                                                    <input type="hidden" name="career_title_dates[{{ $career->id }}]" value="">
                                                @else
                                                    <div class="form-text small mt-1">
                                                        {{ __("Deje en blanco si aún no se ha titulado.") }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
 
                                        <!-- Requirements Status Section -->
                                        <div class="col-md-7 col-sm-12 ps-md-4">
                                            <div class="d-flex flex-column gap-2">
                                                <!-- Course Status -->
                                                <div>
                                                    <span class="fw-semibold small d-block mb-1">{{ __("Estado Académico:") }}</span>
                                                    @if ($pendingCourses->isEmpty())
                                                        <span class="small fw-semibold"><i class="bi bi-check2-circle me-1"></i>{{ __("Sin cursos pendientes (Al día)") }}</span>
                                                     @else
                                                        <span class="small fw-semibold d-block mb-1"><i class="bi bi-x-circle me-1"></i>{{ $pendingCourses->count() }} {{ $pendingCourses->count() == 1 ? 'curso pendiente' : 'cursos pendientes' }}:</span>
                                                        <div class="border p-2 rounded">
                                                            <ul class="list-unstyled mb-0 small ps-0">
                                                                @foreach ($pendingCourses as $course)
                                                                    <li class="d-flex align-items-center gap-1 my-0.5">
                                                                        <span>•</span>
                                                                        <span>{{ $course->code }} - {{ $course->name }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
 
                                                <!-- EFSRT Status -->
                                                <div class="mt-1">
                                                    <span class="fw-semibold small d-block mb-1">{{ __("Estado de Experiencias Formativas (EFSRT):") }}</span>
                                                    @if ($incompleteEfsrt->isEmpty())
                                                        <span class="small fw-semibold"><i class="bi bi-check2-circle me-1"></i>{{ __("Todos los módulos EFSRT completados (3/3)") }}</span>
                                                    @else
                                                        <span class="small fw-semibold d-block mb-1"><i class="bi bi-x-circle me-1"></i>{{ 3 - $incompleteEfsrt->count() }} / 3 {{ __("módulos aprobados") }} ({{ __("Pendientes:") }})</span>
                                                        <div class="border p-2 rounded">
                                                            <ul class="list-unstyled mb-0 small ps-0">
                                                                @foreach ($incompleteEfsrt as $efsrt)
                                                                    <li class="d-flex align-items-center gap-1 my-0.5">
                                                                        <span>•</span>
                                                                        <span>{{ $efsrt->module_name }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Employment Card (Only active if at least one eligible career is titled) -->
                        <div class="card d-none mb-4" id="employment_card">
                            <div class="card-header">
                                <span class="fw-bold"><i class="bi bi-briefcase-fill me-2"></i>{{ __("Información Laboral (Titulados)") }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="current_job" class="form-label small fw-bold  mb-1">{{ __("Trabajo Actual") }}</label>
                                        <input type="text" 
                                               name="current_job" 
                                               id="current_job" 
                                               class="form-control" 
                                               value="{{ old('current_job', $student->job ? $student->job->current_job : '') }}" 
                                               placeholder="Ej: Analista de Sistemas">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="workplace" class="form-label small fw-bold  mb-1">{{ __("Lugar (Empresa/Institución)") }}</label>
                                        <input type="text" 
                                               name="workplace" 
                                               id="workplace" 
                                               class="form-control" 
                                               value="{{ old('workplace', $student->job ? $student->job->workplace : '') }}" 
                                               placeholder="Ej: Banco de la Nación">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="is_related" 
                                                   id="is_related" 
                                                   value="1" 
                                                   {{ old('is_related', $student->job ? $student->job->is_related : false) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold " for="is_related">
                                                {{ __("Es de la carrera que estudió") }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route("students.show", $student->id) }}" class="btn btn-outline-secondary">
                                {{ __("Cancelar") }}
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> {{ __("Guardar Cambios") }}
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
        const gradInputs = document.querySelectorAll(".career-grad-input");
        const titleDateInputs = document.querySelectorAll(".career-title-date-input");
        const employmentCard = document.getElementById("employment_card");

        function toggleEmploymentCard() {
            let isAnyTitled = false;
            gradInputs.forEach(input => {
                if (input.value.trim() !== "") {
                    isAnyTitled = true;
                }
            });
            titleDateInputs.forEach(input => {
                if (input.value.trim() !== "") {
                    isAnyTitled = true;
                }
            });

            if (isAnyTitled) {
                employmentCard.classList.remove("d-none");
            } else {
                employmentCard.classList.add("d-none");
            }
        }

        gradInputs.forEach(input => {
            input.addEventListener("input", toggleEmploymentCard);
            input.addEventListener("change", toggleEmploymentCard);
        });

        titleDateInputs.forEach(input => {
            input.addEventListener("input", toggleEmploymentCard);
            input.addEventListener("change", toggleEmploymentCard);
        });

        // Run initial check
        toggleEmploymentCard();
    });
</script>
@endsection
