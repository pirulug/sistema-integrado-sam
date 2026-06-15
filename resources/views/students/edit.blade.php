@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Editar Estudiante") }}</span>
                    <a href="{{ route("students.index") }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("students.update", $student->id) }}">
                        @csrf
                        @method("PUT")

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __("Nombre Completo") }} *</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error("name") is-invalid @enderror" 
                                       name="name" value="{{ old("name", $student->name) }}" required autofocus>
                                @error("name")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="student_code" class="col-md-4 col-form-label text-md-end">{{ __("Código de Estudiante") }}</label>
                            <div class="col-md-6">
                                <input id="student_code" type="text" class="form-control @error("student_code") is-invalid @enderror" 
                                       name="student_code" value="{{ old("student_code", $student->student_code) }}">
                                @error("student_code")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="document_number" class="col-md-4 col-form-label text-md-end">{{ __("Documento Identidad") }} *</label>
                            <div class="col-md-6">
                                <input id="document_number" type="text" class="form-control @error("document_number") is-invalid @enderror" 
                                       name="document_number" value="{{ old("document_number", $student->document_number) }}" required>
                                @error("document_number")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __("Teléfono") }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error("phone") is-invalid @enderror" 
                                       name="phone" value="{{ old("phone", $student->phone) }}">
                                @error("phone")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="whatsapp" class="col-md-4 col-form-label text-md-end">{{ __("WhatsApp") }}</label>
                            <div class="col-md-6">
                                <input id="whatsapp" type="text" class="form-control @error("whatsapp") is-invalid @enderror" 
                                       name="whatsapp" value="{{ old("whatsapp", $student->whatsapp) }}">
                                @error("whatsapp")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __("Correo General") }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" 
                                       name="email" value="{{ old("email", $student->email) }}">
                                @error("email")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="personal_email" class="col-md-4 col-form-label text-md-end">{{ __("Correo Personal") }}</label>
                            <div class="col-md-6">
                                <input id="personal_email" type="email" class="form-control @error("personal_email") is-invalid @enderror" 
                                       name="personal_email" value="{{ old("personal_email", $student->personal_email) }}">
                                @error("personal_email")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="institutional_email" class="col-md-4 col-form-label text-md-end">{{ __("Correo Institucional") }}</label>
                            <div class="col-md-6">
                                <input id="institutional_email" type="email" class="form-control @error("institutional_email") is-invalid @enderror" 
                                       name="institutional_email" value="{{ old("institutional_email", $student->institutional_email) }}">
                                @error("institutional_email")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __("Programas de Estudio / Carreras y Turnos") }}</label>
                            <div class="col-md-6">
                                <div class="card p-3 @error("careers") border-danger @enderror" style="max-height: 400px; overflow-y: auto;">
                                    @foreach ($careers as $career)
                                        @php
                                            $isChecked = (is_array(old("careers", $student->careers->pluck("id")->toArray())) && in_array($career->id, old("careers", $student->careers->pluck("id")->toArray())));
                                            $studentCareer = $student->careers->firstWhere("id", $career->id);
                                            $currentShift = $studentCareer ? $studentCareer->pivot->shift : null;
                                            $currentEntryYear = $studentCareer ? $studentCareer->pivot->entry_year : null;
                                            $currentGraduationYear = $studentCareer ? $studentCareer->pivot->graduation_year : null;
                                            $availableShifts = $career->shifts ?? ["Mañana", "Tarde", "Noche"];
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                            <div class="form-check mb-0 flex-grow-1">
                                                <input class="form-check-input career-checkbox" type="checkbox" name="careers[]" value="{{ $career->id }}" id="career_{{ $career->id }}"
                                                    {{ $isChecked ? "checked" : "" }}
                                                    data-career-id="{{ $career->id }}">
                                                <label class="form-check-label fw-bold" for="career_{{ $career->id }}">
                                                    {{ $career->name }}
                                                </label>
                                            </div>
                                            <div class="d-flex gap-2 align-items-center" id="details_group_{{ $career->id }}">
                                                <div>
                                                    <label class="small text-muted d-block" style="font-size: 0.75rem;">Turno</label>
                                                    <select name="career_shifts[{{ $career->id }}]" class="form-select form-select-sm w-auto" id="shift_select_{{ $career->id }}"
                                                        {{ $isChecked ? "" : "disabled" }}>
                                                        @foreach ($availableShifts as $shift)
                                                            <option value="{{ $shift }}" {{ old("career_shifts." . $career->id, $currentShift) == $shift ? "selected" : "" }}>
                                                                {{ $shift }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div style="width: 80px;">
                                                    <label class="small text-muted d-block" style="font-size: 0.75rem;">Ingreso</label>
                                                    <input type="number" name="career_entry_years[{{ $career->id }}]" class="form-control form-control-sm" id="entry_year_{{ $career->id }}" 
                                                           value="{{ old('career_entry_years.' . $career->id, $currentEntryYear ?? date('Y')) }}" min="1900" max="2100" required {{ $isChecked ? "" : "disabled" }}>
                                                </div>
                                                <div style="width: 80px;">
                                                    <label class="small text-muted d-block" style="font-size: 0.75rem;">Egreso</label>
                                                    <input type="number" name="career_graduation_years[{{ $career->id }}]" class="form-control form-control-sm" id="graduation_year_{{ $career->id }}" 
                                                           value="{{ old('career_graduation_years.' . $career->id, $currentGraduationYear) }}" min="1900" max="2100" placeholder="Opcional" {{ $isChecked ? "" : "disabled" }}>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error("careers")
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">{{ __("Estado Estudiante") }} *</label>
                            <div class="col-md-6">
                                <select id="status" class="form-select @error("status") is-invalid @enderror" name="status" required>
                                    <option value="matriculado" {{ old("status", $student->status) === "matriculado" ? "selected" : "" }}>{{ __("Matriculado") }}</option>
                                    <option value="egresado" {{ old("status", $student->status) === "egresado" ? "selected" : "" }}>{{ __("Egresado") }}</option>
                                    <option value="retirado" {{ old("status", $student->status) === "retirado" ? "selected" : "" }}>{{ __("Retirado") }}</option>
                                </select>
                                @error("status")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="enrollment_date" class="col-md-4 col-form-label text-md-end">{{ __("Fecha de Matrícula") }} *</label>
                            <div class="col-md-6">
                                <input id="enrollment_date" type="date" class="form-control @error("enrollment_date") is-invalid @enderror" 
                                       name="enrollment_date" value="{{ old("enrollment_date", $student->enrollment_date) }}" required>
                                @error("enrollment_date")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="graduation_date_group" class="row mb-3 d-none">
                            <label for="graduation_date" class="col-md-4 col-form-label text-md-end">{{ __("Fecha de Egreso") }} *</label>
                            <div class="col-md-6">
                                <input id="graduation_date" type="date" class="form-control @error("graduation_date") is-invalid @enderror" 
                                       name="graduation_date" value="{{ old("graduation_date", $student->graduation_date) }}">
                                @error("graduation_date")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="card mb-4 border-success d-none" id="employment_info_card">
                            <div class="card-header bg-success text-white py-2">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-briefcase-fill me-2"></i>{{ __("Información Laboral (Titulados)") }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="current_job" class="col-md-4 col-form-label text-md-end">{{ __("Trabajo Actual") }}</label>
                                    <div class="col-md-6">
                                        <input id="current_job" type="text" class="form-control @error("current_job") is-invalid @enderror" 
                                               name="current_job" value="{{ old("current_job", $student->job ? $student->job->current_job : '') }}" placeholder="Ej: Desarrollador Junior">
                                        @error("current_job")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="workplace" class="col-md-4 col-form-label text-md-end">{{ __("Lugar (Empresa/Institución)") }}</label>
                                    <div class="col-md-6">
                                        <input id="workplace" type="text" class="form-control @error("workplace") is-invalid @enderror" 
                                               name="workplace" value="{{ old("workplace", $student->job ? $student->job->workplace : '') }}" placeholder="Ej: Banco de la Nación">
                                        @error("workplace")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_related" id="is_related" value="1" {{ old("is_related", $student->job ? $student->job->is_related : false) ? "checked" : "" }}>
                                            <label class="form-check-label fw-semibold" for="is_related">
                                                {{ __("Es de la carrera que estudió") }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Actualizar") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusSelect = document.getElementById("status");
        const graduationGroup = document.getElementById("graduation_date_group");
        const graduationInput = document.getElementById("graduation_date");
        const employmentCard = document.getElementById("employment_info_card");
        const checkboxes = document.querySelectorAll(".career-checkbox");

        function toggleGraduationFields() {
            if (statusSelect.value === "egresado") {
                graduationGroup.classList.remove("d-none");
                graduationInput.setAttribute("required", "required");
            } else {
                graduationGroup.classList.add("d-none");
                graduationInput.removeAttribute("required");
            }
        }

        function checkTituladoStatus() {
            let isTitled = false;
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    const careerId = checkbox.getAttribute("data-career-id");
                    const gradInput = document.getElementById("graduation_year_" + careerId);
                    if (gradInput && gradInput.value.trim() !== "") {
                        isTitled = true;
                    }
                }
            });

            if (isTitled) {
                employmentCard.classList.remove("d-none");
            } else {
                employmentCard.classList.add("d-none");
            }
        }

        statusSelect.addEventListener("change", toggleGraduationFields);
        toggleGraduationFields();

        checkboxes.forEach(function (checkbox) {
            const careerId = checkbox.getAttribute("data-career-id");
            const select = document.getElementById("shift_select_" + careerId);
            const entryInput = document.getElementById("entry_year_" + careerId);
            const gradInput = document.getElementById("graduation_year_" + careerId);

            checkbox.addEventListener("change", function () {
                if (checkbox.checked) {
                    if (select) select.disabled = false;
                    if (entryInput) entryInput.disabled = false;
                    if (gradInput) gradInput.disabled = false;
                } else {
                    if (select) select.disabled = true;
                    if (entryInput) entryInput.disabled = true;
                    if (gradInput) gradInput.disabled = true;
                    if (gradInput) gradInput.value = ""; // clear when unchecked
                }
                checkTituladoStatus();
            });

            if (gradInput) {
                gradInput.addEventListener("input", checkTituladoStatus);
                gradInput.addEventListener("change", checkTituladoStatus);
            }
        });

        // Run initial check
        checkTituladoStatus();
    });
</script>
@endsection
