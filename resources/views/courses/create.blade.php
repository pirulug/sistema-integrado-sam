@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Registrar Nuevo Curso") }}</span>
                    <a href="{{ route("courses.index") }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("courses.store") }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="code" class="col-md-4 col-form-label text-md-end">{{ __("Código") }} *</label>
                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error("code") is-invalid @enderror" 
                                       name="code" value="{{ old("code") }}" placeholder="e.g. INF-101" required autofocus>
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
                                       name="name" value="{{ old("name") }}" required>
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
                                       name="credits" value="{{ old("credits", 3) }}" required min="1" max="10">
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
@endsection
