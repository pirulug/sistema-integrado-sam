@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span class="h5 mb-0">{{ __("Panel de Control / Dashboard") }}</span>
                </div>

                <div class="card-body">
                    <p class="lead mb-4">
                        {{ __("Bienvenido al Sistema Integrado SAM. Seleccione una de las siguientes opciones para gestionar la información de la institución:") }}
                    </p>

                    <div class="row g-4">
                        <!-- Tarjeta de Estudiantes -->
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title">{{ __("Estudiantes") }}</h5>
                                        <h2 class="display-4 my-3 text-body font-weight-bold">{{ $studentsCount }}</h2>
                                        <p class="card-text">{{ __("Estudiantes registrados en el sistema.") }}</p>
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
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title">{{ __("Profesores") }}</h5>
                                        <h2 class="display-4 my-3 text-body font-weight-bold">{{ $teachersCount }}</h2>
                                        <p class="card-text">{{ __("Profesores y personal docente activo.") }}</p>
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
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title">{{ __("Programas de Estudio") }}</h5>
                                        <h2 class="display-4 my-3 text-body font-weight-bold">{{ $careersCount }}</h2>
                                        <p class="card-text">{{ __("Carreras y especialidades ofertadas.") }}</p>
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
                <div class="card-header">
                    <span class="h6 mb-0">{{ __("Accesos Rápidos / Acciones de Registro") }}</span>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3 justify-content-center py-2">
                        <a href="{{ route("students.create") }}" class="btn btn-primary px-4 py-2">
                            {{ __("Registrar Nuevo Estudiante") }}
                        </a>
                        <a href="{{ route("teachers.create") }}" class="btn btn-warning px-4 py-2">
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
