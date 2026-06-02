@extends("layouts.app")

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">{{ __("Detalles del Profesor") }}</span>
                    <div>
                        <a href="{{ route("teachers.edit", $teacher->id) }}" class="btn btn-warning btn-sm text-white me-2">
                            {{ __("Editar") }}
                        </a>
                        <a href="{{ route("teachers.index") }}" class="btn btn-secondary btn-sm">
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
                                    <td>{{ $teacher->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Documento de Identidad") }}</th>
                                    <td>{{ $teacher->document_number }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Correo Electrónico") }}</th>
                                    <td>{{ $teacher->email ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Teléfono") }}</th>
                                    <td>{{ $teacher->phone ?? __("No registrado") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Especialidad") }}</th>
                                    <td>{{ $teacher->specialty }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Estado") }}</th>
                                    <td>
                                        @if ($teacher->status === "activo")
                                            <span class="badge bg-success">{{ __("Activo") }}</span>
                                        @elseif ($teacher->status === "inactivo")
                                            <span class="badge bg-danger">{{ __("Inactivo") }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $teacher->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __("Fecha de Contratación") }}</th>
                                    <td>{{ $teacher->hire_date }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Creado el") }}</th>
                                    <td>{{ $teacher->created_at->format("d/m/Y H:i") }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Última actualización") }}</th>
                                    <td>{{ $teacher->updated_at->format("d/m/Y H:i") }}</td>
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
