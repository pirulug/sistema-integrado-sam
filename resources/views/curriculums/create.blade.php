@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Registrar Nueva Malla Curricular") }}</span>
                    <a href="{{ route("curriculums.index") }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("curriculums.store") }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __("Nombre de Malla") }} *</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error("name") is-invalid @enderror" 
                                       name="name" value="{{ old("name") }}" placeholder="e.g. Malla Curricular 2024" required autofocus>
                                @error("name")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="year" class="col-md-4 col-form-label text-md-end">{{ __("Año de Malla") }} *</label>
                            <div class="col-md-6">
                                <input id="year" type="number" class="form-control @error("year") is-invalid @enderror" 
                                       name="year" value="{{ old("year", date("Y")) }}" required min="1900" max="2100">
                                @error("year")
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
                                    <option value="">{{ __("Seleccionar Carrera") }}</option>
                                    @foreach ($careers as $career)
                                        <option value="{{ $career->id }}" {{ old("career_id") == $career->id ? "selected" : "" }}>
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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Registrar Malla") }}
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
