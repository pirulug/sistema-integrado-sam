@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Registrar Nuevo Profesor") }}</span>
                    <a href="{{ route("teachers.index") }}" class="btn btn-secondary btn-sm">
                        {{ __("Volver") }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("teachers.store") }}">
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
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __("Correo Electrónico") }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" 
                                       name="email" value="{{ old("email") }}">
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
                                       name="phone" value="{{ old("phone") }}">
                                @error("phone")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="specialty" class="col-md-4 col-form-label text-md-end">{{ __("Especialidad") }} *</label>
                            <div class="col-md-6">
                                <input id="specialty" type="text" class="form-control @error("specialty") is-invalid @enderror" 
                                       name="specialty" value="{{ old("specialty") }}" required>
                                @error("specialty")
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
                                    <option value="activo" {{ old("status") === "activo" ? "selected" : "" }}>{{ __("Activo") }}</option>
                                    <option value="inactivo" {{ old("status") === "inactivo" ? "selected" : "" }}>{{ __("Inactivo") }}</option>
                                </select>
                                @error("status")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hire_date" class="col-md-4 col-form-label text-md-end">{{ __("Fecha de Contratación") }} *</label>
                            <div class="col-md-6">
                                <input id="hire_date" type="date" class="form-control @error("hire_date") is-invalid @enderror" 
                                       name="hire_date" value="{{ old("hire_date", date("Y-m-d")) }}" required>
                                @error("hire_date")
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
