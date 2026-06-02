@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Detalles del Estudiante") }}</span>
                    <div>
                        <a href="{{ route("students.edit", $student->id) }}" class="btn btn-warning btn-sm text-white me-2">
                            {{ __("Editar") }}
                        </a>
                        <a href="{{ route("students.index") }}" class="btn btn-secondary btn-sm">
                            {{ __("Volver") }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th class="w-30">{{ __("Nombre Completo") }}</th>
                                    <td>{{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Documento de Identidad") }}</th>
                                    <td>{{ $student->document_number }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Correo Electrónico") }}</th>
                                    <td>{{ $student->email ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Teléfono") }}</th>
                                    <td>{{ $student->phone ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Estado") }}</th>
                                    <td>
                                        @if ($student->status === "matriculado")
                                            <span class="badge bg-success">{{ __("Matriculado") }}</span>
                                        @elseif ($student->status === "egresado")
                                            <span class="badge bg-primary">{{ __("Egresado") }}</span>
                                        @elseif ($student->status === "retirado")
                                            <span class="badge bg-danger">{{ __("Retirado") }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $student->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Fecha de Matrícula") }}</th>
                                    <td>{{ $student->enrollment_date }}</td>
                                </tr>
                                @if ($student->status === "egresado")
                                    <tr>
                                        <th>{{ __("Fecha de Egreso") }}</th>
                                        <td>{{ $student->graduation_date ?? __("No registrada") }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>{{ __("Creado el") }}</th>
                                    <td>{{ $student->created_at->format("d/m/Y H:i") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Última actualización") }}</th>
                                    <td>{{ $student->updated_at->format("d/m/Y H:i") }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
