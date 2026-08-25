<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Profesores") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Info Alert -->
            @if (session("info"))
                <div class="p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-md dark:bg-blue-900/30 dark:text-blue-400 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 me-2 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-medium text-sm">{{ session("info") }}</p>
                    </div>
                </div>
            @endif

            <!-- Success Alert -->
            @if (session("success"))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-md dark:bg-green-900/30 dark:text-green-400 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 me-2 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="font-medium text-sm">{{ session("success") }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Alert -->
            @if (session("error"))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md dark:bg-red-900/30 dark:text-red-400 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 me-2 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <p class="font-medium text-sm">{{ session("error") }}</p>
                    </div>
                </div>
            @endif

            <!-- Import Warnings / Errors -->
            @if (session("import_errors"))
                <div class="p-4 bg-amber-50 border-l-4 border-amber-500 text-amber-800 rounded-md dark:bg-amber-900/30 dark:text-amber-300 shadow-sm" role="alert" x-data="{ expanded: false }">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="h-5 w-5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="font-semibold text-sm">Observaciones durante la importación ({{ count(session("import_errors")) }} filas con avisos):</p>
                        </div>
                        <button type="button" @click="expanded = !expanded" class="text-xs font-medium text-amber-800 dark:text-amber-200 underline focus:outline-none">
                            <span x-show="!expanded">Ver detalles</span>
                            <span x-show="expanded" style="display: none;">Ocultar</span>
                        </button>
                    </div>
                    <ul x-show="expanded" style="display: none;" class="mt-3 text-xs space-y-1 list-disc list-inside max-h-48 overflow-y-auto pl-2 border-t border-amber-200 dark:border-amber-700/50 pt-2">
                        @foreach (session("import_errors") as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between pb-6 space-y-4 md:space-y-0">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('teachers.index') }}" class="w-full md:w-1/2 flex items-center">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por DNI, Código o Nombre..." class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" />
                            <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Buscar
                            </button>
                            @if ($search)
                                <a href="{{ route('teachers.index') }}" class="ms-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 underline">
                                    Limpiar
                                </a>
                            @endif
                        </form>

                        <!-- Action Buttons -->
                        @if (Auth::user()->isAdmin())
                            <div class="flex items-center space-x-3">
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'import-teachers-modal')" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Importar CSV
                                </button>

                                <a href="{{ route('teachers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Registrar Profesor
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Teachers Table -->
                    @if ($teachers->isEmpty())
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            No se encontraron profesores.
                        </div>
                    @else
                        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Profesor</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">DNI</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email Institucional</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($teachers as $teacher)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-3">
                                                    @if ($teacher->photo_url)
                                                        <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-10 h-10 rounded-full object-cover border border-indigo-200 dark:border-indigo-800 shadow-sm flex-shrink-0">
                                                    @else
                                                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-sm flex-shrink-0">
                                                            {{ strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->paternal_last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $teacher->full_name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $teacher->personal_email ?? 'Sin correo personal' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700 dark:text-gray-300">{{ $teacher->dni }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                    {{ $teacher->teacher_code }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">{{ $teacher->institutional_email }}</div>
                                                @if ($teacher->user_id)
                                                    <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span> Cuenta activa
                                                    </span>
                                                @else
                                                    <a href="{{ route('users.create', ['teacher_id' => $teacher->id, 'role' => 'teacher']) }}" class="inline-flex items-center text-[10px] font-bold text-amber-600 dark:text-amber-400 hover:underline">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1"></span> Sin usuario &bull; Crear &rarr;
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                                <a href="{{ route('teachers.show', $teacher) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold">Ver</a>
                                                @if (Auth::user()->isAdmin())
                                                    <a href="{{ route('teachers.edit', $teacher) }}" class="text-amber-600 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300 font-semibold">Editar</a>
                                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de que desea eliminar a este profesor?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold">Eliminar</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $teachers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Importar Profesores CSV -->
    <x-modal name="import-teachers-modal" :show="$errors->has('file')" maxWidth="2xl">
        <form method="POST" action="{{ route('teachers.import') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Importar Profesores desde CSV
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Cargue un archivo CSV para registrar o actualizar profesores en lote.
                        </p>
                    </div>
                </div>
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-6 space-y-6">
                <!-- File Input -->
                <div>
                    <label for="csv_file_teacher" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Archivo CSV <span class="text-red-500">*</span>
                    </label>
                    <input id="csv_file_teacher" name="file" type="file" accept=".csv,text/csv,text/plain" required class="block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 p-2.5" />
                    <x-input-error class="mt-2" :messages="$errors->get('file')" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Formatos admitidos: .csv, .txt (Máximo 10 MB).
                    </p>
                </div>

                <!-- Delimiter Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Separador / Delimitador del CSV <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="relative flex items-center p-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition">
                            <input type="radio" name="delimiter" value="," checked class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 dark:border-gray-600" />
                            <div class="ms-3">
                                <span class="block text-xs font-semibold text-gray-900 dark:text-gray-100">Coma ( , )</span>
                                <span class="block text-[11px] text-gray-500 dark:text-gray-400">Estándar internacional</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition">
                            <input type="radio" name="delimiter" value=";" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 dark:border-gray-600" />
                            <div class="ms-3">
                                <span class="block text-xs font-semibold text-gray-900 dark:text-gray-100">Punto y coma ( ; )</span>
                                <span class="block text-[11px] text-gray-500 dark:text-gray-400">Común en Excel español</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition">
                            <input type="radio" name="delimiter" value="auto" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 dark:border-gray-600" />
                            <div class="ms-3">
                                <span class="block text-xs font-semibold text-gray-900 dark:text-gray-100">Automático</span>
                                <span class="block text-[11px] text-gray-500 dark:text-gray-400">Detectar por encabezado</span>
                            </div>
                        </label>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('delimiter')" />
                </div>

                <!-- Duplicate Notice -->
                <div class="p-3 bg-blue-50 dark:bg-blue-950/30 rounded-lg border border-blue-200 dark:border-blue-800/60 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-xs text-blue-800 dark:text-blue-300 leading-relaxed">
                        <strong>Gestión inteligente de duplicados:</strong> Si el archivo contiene registros con DNI, código o email ya existentes, no se descartarán automáticamente; el sistema guardará los registros válidos y te mostrará una pantalla interactiva para editar, actualizar u omitir los duplicados.
                    </div>
                </div>

                <!-- Download Templates Box -->
                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                        Descargar Plantilla de Ejemplo
                    </h4>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('teachers.template', ['delimiter' => ',']) }}" class="inline-flex items-center text-xs font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 underline">
                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Plantilla con Coma ( , )
                        </a>
                        <span class="text-gray-400">|</span>
                        <a href="{{ route('teachers.template', ['delimiter' => ';']) }}" class="inline-flex items-center text-xs font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 underline">
                            <svg class="w-3.5 h-3.5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Plantilla con Punto y coma ( ; )
                        </a>
                    </div>
                    <p class="mt-2 text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                        Columnas requeridas: <strong>dni, codigo, apellido_paterno, apellido_materno, nombres</strong>.<br />
                        Columnas opcionales: email_institucional, email_personal, telefono, celular, fecha_contratacion, <strong>contrasena</strong> (crea la cuenta de usuario automáticamente).
                    </p>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="mt-6 flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Cancelar
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Procesar Importación
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
