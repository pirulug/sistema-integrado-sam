@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Gestión de Estudiantes") }}</span>
                    <a href="{{ route("students.create") }}" class="btn btn-primary btn-sm">
                        {{ __("Registrar Estudiante") }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session("success"))
                        <div class="alert alert-success" role="alert">
                            {{ session("success") }}
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-body p-3">
                            <form method="GET" action="{{ route("students.index") }}">
                                <div class="row g-3">
                                    <!-- Search Name, Document, Phone -->
                                    <div class="col-md-4 col-sm-12">
                                        <label for="search" class="form-label small fw-bold mb-1">{{ __("Buscador") }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="search" name="search" value="{{ request("search") }}" placeholder="Nombre, DNI o teléfono...">
                                        </div>
                                    </div>

                                    <!-- Career -->
                                    <div class="col-md-2 col-sm-6">
                                        <label for="career_id" class="form-label small fw-bold mb-1">{{ __("Carrera") }}</label>
                                        <select class="form-select" id="career_id" name="career_id">
                                            <option value="todos">{{ __("Todas") }}</option>
                                            @foreach ($careers as $c)
                                                <option value="{{ $c->id }}" {{ request("career_id") == $c->id ? "selected" : "" }}>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Shift -->
                                    <div class="col-md-2 col-sm-6">
                                        <label for="shift" class="form-label small fw-bold mb-1">{{ __("Turno") }}</label>
                                        <select class="form-select" id="shift" name="shift">
                                            <option value="todos">{{ __("Todos") }}</option>
                                            <option value="Mañana" {{ request("shift") === "Mañana" ? "selected" : "" }}>{{ __("Mañana") }}</option>
                                            <option value="Tarde" {{ request("shift") === "Tarde" ? "selected" : "" }}>{{ __("Tarde") }}</option>
                                            <option value="Noche" {{ request("shift") === "Noche" ? "selected" : "" }}>{{ __("Noche") }}</option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-2 col-sm-6">
                                        <label for="status" class="form-label small fw-bold mb-1">{{ __("Estado") }}</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="todos" {{ request("status") === "todos" || !request("status") ? "selected" : "" }}>{{ __("Todos") }}</option>
                                            <option value="matriculado" {{ request("status") === "matriculado" ? "selected" : "" }}>{{ __("Matriculado") }}</option>
                                            <option value="egresado" {{ request("status") === "egresado" ? "selected" : "" }}>{{ __("Egresado") }}</option>
                                            <option value="titulado" {{ request("status") === "titulado" ? "selected" : "" }}>{{ __("Titulado") }}</option>
                                            <option value="retirado" {{ request("status") === "retirado" ? "selected" : "" }}>{{ __("Retirado") }}</option>
                                        </select>
                                    </div>

                                    <!-- Year -->
                                    <div class="col-md-2 col-sm-6">
                                        <label for="year" class="form-label small fw-bold mb-1">{{ __("Año Promoción") }}</label>
                                        <input type="number" class="form-control" id="year" name="year" value="{{ request("year") }}" placeholder="Ej: 2024" min="1900" max="2100">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route("students.index") }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-arrow-counterclockwise"></i> {{ __("Limpiar") }}
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-funnel"></i> {{ __("Filtrar") }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="ps-3">{{ __("Estudiante") }}</th>
                                    <th class="text-center">{{ __("Turno/Promoción") }}</th>
                                    <th class="text-center">{{ __("Módulos EFSRT") }}</th>
                                    <th class="text-center">{{ __("Titulación") }}</th>
                                    <th class="text-center">{{ __("Curso") }}</th>
                                    <th class="text-center pe-3">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <!-- ESTUDIANTE -->
                                        <td class="ps-3 py-3">
                                            <div class="fw-bold text-body mb-1" style="font-size: 0.95rem;">{{ $student->name }}</div>
                                            <div class="d-flex align-items-center gap-1 small">
                                                <i class="bi bi-person-vcard"></i>
                                                <span>{{ $student->document_number }}</span>
                                                @if ($student->phone)
                                                    <span class="mx-2">|</span>
                                                    <i class="bi bi-telephone"></i>
                                                    <span>{{ $student->phone }}</span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- TURNO/PROMOCIÓN -->
                                        <td class="text-center py-3">
                                            <div class="d-flex flex-column gap-3">
                                                @foreach ($student->careers as $career)
                                                    <div style="min-height: 85px;" class="d-flex flex-column justify-content-center align-items-center">
                                                        <div class="fw-bold text-body small">{{ $career->name }}</div>
                                                        @if ($career->pivot->shift)
                                                            @php
                                                                $rawShift = $career->pivot->shift;
                                                                $shiftName = in_array($rawShift, ['Mañana', 'Tarde']) ? 'Diurno' : 'Nocturno';
                                                            @endphp
                                                            <span class="badge rounded-pill {{ $shiftName === 'Diurno' ? 'bg-info' : 'bg-secondary' }} px-2.5 py-1 mt-1 fw-bold" style="font-size: 0.72rem;">
                                                                {{ $shiftName }} ({{ $rawShift }})
                                                            </span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary px-2.5 py-1 mt-1 fw-semibold" style="font-size: 0.72rem;">
                                                                Sin turno
                                                            </span>
                                                        @endif
                                                        <div class="small mt-2 fw-semibold" style="font-size: 0.82rem;">
                                                            <i class="bi bi-calendar3 me-1"></i>
                                                            <span>
                                                                {{ $career->pivot->entry_year ?? $student->entry_year }}
                                                                @if ($career->pivot->graduation_year)
                                                                    - {{ $career->pivot->graduation_year }}
                                                                @elseif ($student->status === 'egresado')
                                                                    - Egresado
                                                                @else
                                                                    - Presente
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if ($student->careers->isEmpty())
                                                    <div class="small">Sin carrera</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex flex-column gap-3">
                                                @foreach ($student->careers as $career)
                                                    <div style="min-height: 85px;" class="d-flex justify-content-center align-items-center">
                                                        @php
                                                            $careerEfsrt = $student->efsrtRecords->where('career_id', $career->id);
                                                            $showEfsrt = $careerEfsrt->whereIn('status', ['aprobado', 'desaprobado'])->isNotEmpty();
                                                        @endphp
                                                        @if ($showEfsrt)
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                @foreach (['MODULO I', 'MODULO II', 'MODULO III'] as $mod)
                                                                    @php
                                                                        $record = $careerEfsrt->firstWhere('module_name', $mod);
                                                                        $isApproved = $record && $record->status === 'aprobado';
                                                                    @endphp
                                                                    @if ($isApproved)
                                                                        <i class="bi bi-check-circle-fill text-success fs-5" title="{{ $mod }}: Aprobado"></i>
                                                                    @else
                                                                        <i class="bi bi-x-circle-fill text-danger fs-5" title="{{ $mod }}: Pendiente" style="opacity: 0.8;"></i>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="small">-</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if ($student->careers->isEmpty())
                                                    <div class="small">-</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex flex-column gap-3">
                                                @foreach ($student->careers as $career)
                                                    <div style="min-height: 85px;" class="d-flex justify-content-center align-items-center">
                                                        @if ($career->pivot->graduation_year)
                                                            <span class="badge rounded-pill bg-success px-3 py-1.5" style="font-size: 0.78rem; font-weight: 600;">
                                                                Titulado
                                                            </span>
                                                        @else
                                                            @if ($student->status === 'egresado')
                                                                <span class="badge rounded-pill bg-primary px-3 py-1.5" style="font-size: 0.78rem; font-weight: 600;">
                                                                    Egresado
                                                                </span>
                                                            @elseif ($student->status === 'matriculado')
                                                                <span class="badge rounded-pill bg-success px-3 py-1.5" style="font-size: 0.78rem; font-weight: 600;">
                                                                    Matriculado
                                                                </span>
                                                            @else
                                                                <span class="badge rounded-pill bg-danger px-3 py-1.5" style="font-size: 0.78rem; font-weight: 600;">
                                                                    Retirado
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if ($student->careers->isEmpty())
                                                    <div class="small">-</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex flex-column gap-3">
                                                @foreach ($student->careers as $career)
                                                    <div style="min-height: 85px;" class="d-flex flex-column justify-content-center align-items-center">
                                                        @php
                                                            $careerCourses = $career->courses;
                                                            $passedCourseIds = $student->courses
                                                                ->filter(fn($c) => $c->pivot->status === 'aprobado')
                                                                ->pluck('id')
                                                                ->toArray();
                                                            $pendingCourses = $careerCourses->filter(fn($c) => !in_array($c->id, $passedCourseIds));
                                                            $pendingCount = $pendingCourses->count();
                                                        @endphp
                                                        @if ($pendingCount > 0)
                                                            <span class="text-danger fw-semibold" style="font-size: 0.88rem;">
                                                                {{ $pendingCount }} U.D. {{ $pendingCount == 1 ? 'pendiente' : 'pendientes' }}
                                                            </span>
                                                            <a class="text-decoration-none d-block small mt-1 fw-semibold" data-bs-toggle="collapse" href="#pending-courses-{{ $student->id }}-{{ $career->id }}" role="button" aria-expanded="false" aria-controls="pending-courses-{{ $student->id }}-{{ $career->id }}" style="font-size: 0.82rem;">
                                                                Ver cursos <i class="bi bi-chevron-down small ms-0.5"></i>
                                                            </a>
                                                            <div class="collapse mt-1" id="pending-courses-{{ $student->id }}-{{ $career->id }}">
                                                                <ul class="list-unstyled mb-0 small ps-0 mt-1">
                                                                    @foreach ($pendingCourses as $course)
                                                                        <li class="d-flex align-items-center gap-1 my-0.5" style="font-size: 0.82rem;">
                                                                            <span>•</span>
                                                                            <span>{{ $course->name }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @else
                                                            <span class="text-success fw-semibold" style="font-size: 0.88rem;">
                                                                Al día (0 U.D.)
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if ($student->careers->isEmpty())
                                                    <div class="small">-</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center pe-3">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route("students.show", $student->id) }}" class="btn btn-info btn-sm" title="{{ __("Ver") }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route("students.efsrt.edit", $student->id) }}" class="btn btn-primary btn-sm" title="{{ __("EFSRT") }}">
                                                    <i class="bi bi-journal-check"></i>
                                                </a>
                                                <a href="{{ route("students.courses.edit", $student->id) }}" class="btn btn-success btn-sm" title="{{ __("CURSOS") }}">
                                                    <i class="bi bi-book"></i>
                                                </a>
                                                <a href="{{ route("students.graduation.edit", $student->id) }}" class="btn btn-secondary btn-sm" title="{{ __("Graduación/Titulación") }}">
                                                    <i class="bi bi-mortarboard"></i>
                                                </a>
                                                <a href="{{ route("students.edit", $student->id) }}" class="btn btn-warning btn-sm" title="{{ __("Editar") }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route("students.destroy", $student->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este estudiante?');">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __("Eliminar") }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            {{ __("No se encontraron estudiantes registrados.") }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
