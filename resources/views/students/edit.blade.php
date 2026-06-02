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
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __("Correo Electrónico") }}</label>
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
                            <label for="status" class="col-md-4 col-form-label text-md-end">{{ __("Estado") }} *</label>
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

        function toggleGraduationDate() {
            if (statusSelect.value === "egresado") {
                graduationGroup.classList.remove("d-none");
                graduationInput.setAttribute("required", "required");
            } else {
                graduationGroup.classList.add("d-none");
                graduationInput.removeAttribute("required");
            }
        }

        statusSelect.addEventListener("change", toggleGraduationDate);
        toggleGraduationDate();
    });
</script>
@endsection
