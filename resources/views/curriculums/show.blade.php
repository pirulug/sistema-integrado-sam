@extends("layouts.app")

@section("content")
<div class="container">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <span class="small d-block text-uppercase fw-bold">{{ __("Estructura Curricular") }}</span>
                <h5 class="mb-0 fw-bold">{{ $curriculum->name }} ({{ $curriculum->year }})</h5>
            </div>
            <div>
                <a href="{{ route("courses.create", ["career_id" => $curriculum->career_id, "curriculum_id" => $curriculum->id]) }}" class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-plus-lg"></i> {{ __("Agregar Curso") }}
                </a>
                <a href="{{ route("curriculums.index") }}" class="btn btn-secondary btn-sm">
                    {{ __("Volver") }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <strong>{{ __("Carrera Profesional:") }}</strong> {{ $curriculum->career->name }}
                </div>
                <div class="col-md-6">
                    <strong>{{ __("Total Cursos:") }}</strong> {{ $curriculum->courses->count() }}
                </div>
            </div>
        </div>
    </div>

    @if ($groupedCourses->isEmpty())
        <div class="alert alert-info text-center py-4">
            {{ __("No hay cursos registrados en esta malla curricular.") }}
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($groupedCourses as $periodNum => $courses)
                @php
                    $romanPeriod = $romanPeriods[$periodNum] ?? $periodNum;
                    $periodCredits = $courses->sum("credits");
                    $periodHours = $courses->sum("hours");
                @endphp
                <div class="col">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-uppercase">{{ __("Periodo ") }}{{ $romanPeriod }}</h6>
                            <span class="badge border border-secondary text-reset small">
                                {{ $periodCredits }} cr | {{ $periodHours }} hrs
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0" style="font-size: 0.9rem;">
                                    <thead>
                                        <tr>
                                            <th>{{ __("Código") }}</th>
                                            <th>{{ __("Curso") }}</th>
                                            <th class="text-center">{{ __("Cr") }}</th>
                                            <th class="text-center">{{ __("Hrs") }}</th>
                                            <th class="text-center">{{ __("Acciones") }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $course)
                                            <tr>
                                                <td><strong>{{ $course->code }}</strong></td>
                                                <td>{{ $course->name }}</td>
                                                <td class="text-center">{{ $course->credits }}</td>
                                                <td class="text-center">{{ $course->hours }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route("courses.edit", $course->id) }}" class="btn btn-warning btn-sm py-0 px-1" title="{{ __("Editar") }}">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route("courses.destroy", $course->id) }}" method="POST" class="d-inline"
                                                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso?');">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" class="btn btn-danger btn-sm py-0 px-1" title="{{ __("Eliminar") }}">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
