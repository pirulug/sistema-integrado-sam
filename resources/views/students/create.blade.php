@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Registrar Nuevo Estudiante") }}</span>
                    <a href="{{ route("students.index") }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("students.store") }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __("Nombre Completo") }} *</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error("name") is-invalid @enderror" 
                                       name="name" value="{{ old("name") }}" required autofocus>
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
                                       name="student_code" value="{{ old("student_code") }}">
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
                                       name="document_number" value="{{ old("document_number") }}" required>
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
                                       name="phone" value="{{ old("phone") }}">
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
                                       name="whatsapp" value="{{ old("whatsapp") }}">
                                @error("whatsapp")
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
                                       name="personal_email" value="{{ old("personal_email") }}">
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
                                       name="institutional_email" value="{{ old("institutional_email") }}">
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
                                            $isChecked = (is_array(old("careers")) && in_array($career->id, old("careers")));
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
                                                    <label class="small d-block" style="font-size: 0.75rem;">Turno</label>
                                                    <select name="career_shifts[{{ $career->id }}]" class="form-select form-select-sm w-auto" id="shift_select_{{ $career->id }}"
                                                        {{ $isChecked ? "" : "disabled" }}>
                                                        @foreach ($availableShifts as $shift)
                                                            <option value="{{ $shift }}" {{ old("career_shifts." . $career->id) == $shift ? "selected" : "" }}>
                                                                {{ $shift }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div style="width: 80px;">
                                                    <label class="small d-block" style="font-size: 0.75rem;">Ingreso</label>
                                                    <input type="number" name="career_entry_years[{{ $career->id }}]" class="form-control form-control-sm" id="entry_year_{{ $career->id }}" 
                                                           value="{{ old('career_entry_years.' . $career->id, date('Y')) }}" min="1900" max="2100" required {{ $isChecked ? "" : "disabled" }}>
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
                                    <option value="matriculado" {{ old("status") === "matriculado" ? "selected" : "" }}>{{ __("Matriculado") }}</option>
                                    <option value="egresado" {{ old("status") === "egresado" ? "selected" : "" }}>{{ __("Egresado") }}</option>
                                    <option value="retirado" {{ old("status") === "retirado" ? "selected" : "" }}>{{ __("Retirado") }}</option>
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
                                       name="enrollment_date" value="{{ old("enrollment_date", date("Y-m-d")) }}" required>
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
                                       name="graduation_date" value="{{ old("graduation_date") }}">
                                @error("graduation_date")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Registrar") }}
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

        statusSelect.addEventListener("change", toggleGraduationFields);
        toggleGraduationFields();

        checkboxes.forEach(function (checkbox) {
            const careerId = checkbox.getAttribute("data-career-id");
            const select = document.getElementById("shift_select_" + careerId);
            const entryInput = document.getElementById("entry_year_" + careerId);

            checkbox.addEventListener("change", function () {
                if (checkbox.checked) {
                    if (select) select.disabled = false;
                    if (entryInput) entryInput.disabled = false;
                } else {
                    if (select) select.disabled = true;
                    if (entryInput) entryInput.disabled = true;
                }
            });
        });
    });
</script>
@endsection
