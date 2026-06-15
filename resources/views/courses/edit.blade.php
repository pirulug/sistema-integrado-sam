@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Editar Curso") }}</span>
                    <a href="{{ route("courses.index") }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("courses.update", $course->id) }}">
                        @csrf
                        @method("PUT")

                        <div class="row mb-3">
                            <label for="code" class="col-md-4 col-form-label text-md-end">{{ __("Código") }} *</label>
                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error("code") is-invalid @enderror" 
                                       name="code" value="{{ old("code", $course->code) }}" required autofocus>
                                @error("code")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __("Nombre del Curso") }} *</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error("name") is-invalid @enderror" 
                                       name="name" value="{{ old("name", $course->name) }}" required>
                                @error("name")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="credits" class="col-md-4 col-form-label text-md-end">{{ __("Créditos") }} *</label>
                            <div class="col-md-6">
                                <input id="credits" type="number" class="form-control @error("credits") is-invalid @enderror" 
                                       name="credits" value="{{ old("credits", $course->credits) }}" required min="1" max="10">
                                @error("credits")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="career_id" class="col-md-4 col-form-label text-md-end">{{ __("Carrera Profesional") }} *</label>
                            <div class="col-md-6">
                                <select id="career_id" class="form-select @error("career_id") is-invalid @enderror" name="career_id" required>
                                    @foreach ($careers as $career)
                                        <option value="{{ $career->id }}" {{ old("career_id", $course->career_id) == $career->id ? "selected" : "" }}>
                                            {{ $career->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("career_id")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hours" class="col-md-4 col-form-label text-md-end">{{ __("Horas") }} *</label>
                            <div class="col-md-6">
                                <input id="hours" type="number" class="form-control @error("hours") is-invalid @enderror" 
                                       name="hours" value="{{ old("hours", $course->hours) }}" required min="0">
                                @error("hours")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="curriculum_id" class="col-md-4 col-form-label text-md-end">{{ __("Malla Curricular") }} *</label>
                            <div class="col-md-6">
                                <select id="curriculum_id" class="form-select @error("curriculum_id") is-invalid @enderror" name="curriculum_id" required>
                                    <option value="">{{ __("Seleccionar Malla...") }}</option>
                                    @foreach ($curriculums as $curr)
                                        <option value="{{ $curr->id }}" data-career-id="{{ $curr->career_id }}" {{ old("curriculum_id", $course->curriculum_id) == $curr->id ? "selected" : "" }}>
                                            {{ $curr->name }} ({{ $curr->year }})
                                        </option>
                                    @endforeach
                                </select>
                                @error("curriculum_id")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_actualizacion" id="is_actualizacion" value="1" {{ old("is_actualizacion", $course->is_actualizacion) ? "checked" : "" }}>
                                    <label class="form-check-label" for="is_actualizacion">
                                        {{ __("Es curso de actualización (Alumnos antiguos)") }}
                                    </label>
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
@endsection

@section("scripts")
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const careerSelect = document.getElementById("career_id");
        const curriculumSelect = document.getElementById("curriculum_id");
        
        if (careerSelect && curriculumSelect) {
            const allOptions = Array.from(curriculumSelect.options);
            const selectedVal = "{{ old('curriculum_id', $course->curriculum_id) }}";
            
            function filterCurriculums() {
                const careerId = careerSelect.value;
                curriculumSelect.innerHTML = "";
                
                // Add empty option
                const defaultOption = allOptions[0];
                curriculumSelect.appendChild(defaultOption);
                
                allOptions.forEach(option => {
                    if (option.value !== "" && option.getAttribute("data-career-id") == careerId) {
                        curriculumSelect.appendChild(option);
                    }
                });
                
                if (selectedVal) {
                    curriculumSelect.value = selectedVal;
                }
            }
            
            careerSelect.addEventListener("change", filterCurriculums);
            if (careerSelect.value !== "") {
                filterCurriculums();
            }
        }
    });
</script>
@endsection
