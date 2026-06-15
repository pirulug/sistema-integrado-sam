@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white h5 mb-0 py-3">
                    {{ __("Panel de Control / Dashboard") }}
                </div>

                <div class="card-body py-4">
                    <p class="lead mb-4">
                        {{ __("Bienvenido al Sistema Integrado SAM. Seleccione una de las siguientes opciones para gestionar la información de la institución:") }}
                    </p>

                    <div class="row g-4">
                        <!-- Tarjeta de Estudiantes -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title text-primary">{{ __("Estudiantes") }}</h5>
                                        <h2 class="display-4 my-3 text-body font-weight-bold">{{ $studentsCount }}</h2>
                                        <p class="card-text text-muted">{{ __("Estudiantes registrados en el sistema.") }}</p>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route("students.index") }}" class="btn btn-outline-primary w-100">
                                            {{ __("Administrar Estudiantes") }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Profesores -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-warning">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title text-warning">{{ __("Profesores") }}</h5>
                                        <h2 class="display-4 my-3 text-body font-weight-bold">{{ $teachersCount }}</h2>
                                        <p class="card-text text-muted">{{ __("Profesores y personal docente activo.") }}</p>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route("teachers.index") }}" class="btn btn-outline-warning w-100">
                                            {{ __("Administrar Profesores") }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Carreras -->
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-success">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title text-success">{{ __("Programas de Estudio") }}</h5>
                                        <h2 class="display-4 my-3 text-body font-weight-bold">{{ $careersCount }}</h2>
                                        <p class="card-text text-muted">{{ __("Carreras y especialidades ofertadas.") }}</p>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route("careers.index") }}" class="btn btn-outline-success w-100">
                                            {{ __("Administrar Carreras") }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="card">
                <div class="card-header bg-light h6 mb-0 py-3">
                    {{ __("Accesos Rápidos / Acciones de Registro") }}
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3 justify-content-center py-2">
                        <a href="{{ route("students.create") }}" class="btn btn-primary px-4 py-2">
                            {{ __("Registrar Nuevo Estudiante") }}
                        </a>
                        <a href="{{ route("teachers.create") }}" class="btn btn-warning text-white px-4 py-2">
                            {{ __("Registrar Nuevo Profesor") }}
                        </a>
                        <a href="{{ route("careers.create") }}" class="btn btn-success px-4 py-2">
                            {{ __("Registrar Nuevo Programa de Estudio") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
