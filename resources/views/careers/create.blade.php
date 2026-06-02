@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Registrar Nuevo Programa de Estudio") }}</span>
                    <a href="{{ route("careers.index") }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("careers.store") }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __("Nombre de la Carrera") }} *</label>
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
                            <label for="code" class="col-md-4 col-form-label text-md-end">{{ __("Código o Sigla") }}</label>
                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error("code") is-invalid @enderror" 
                                       name="code" value="{{ old("code") }}">
                                @error("code")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __("Descripción") }}</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error("description") is-invalid @enderror" 
                                          name="description" rows="4">{{ old("description") }}</textarea>
                                @error("description")
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
                                    <option value="activo" {{ old("status", "activo") === "activo" ? "selected" : "" }}>{{ __("Activo") }}</option>
                                    <option value="inactivo" {{ old("status") === "inactivo" ? "selected" : "" }}>{{ __("Inactivo") }}</option>
                                </select>
                                @error("status")
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
