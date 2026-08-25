<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2.5">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Editar Usuario: {{ $user->name }}</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    @if ($user->role === 'teacher')
                        Gestión de credenciales de acceso para este docente. Los datos personales se editan en el CRUD de Profesores.
                    @else
                        Modifique los datos de la cuenta de usuario, rol o restablezca su contraseña.
                    @endif
                </p>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-3.5 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl text-xs font-bold shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Volver a la Lista</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alerts -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-800 dark:text-emerald-300 text-sm font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="p-4 bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 rounded-xl text-blue-800 dark:text-blue-300 text-sm font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if ($user->role === 'teacher')
                <!-- Banner: Aviso y enlace al CRUD de Profesores -->
                <div class="p-5 bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 rounded-2xl shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/60 rounded-xl text-blue-700 dark:text-blue-300 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-blue-900 dark:text-blue-200">
                                Edición de Datos Personales del Docente
                            </h3>
                            <p class="text-xs text-blue-700 dark:text-blue-300 mt-0.5 leading-relaxed">
                                Este usuario pertenece a un <strong>Profesor</strong>. Para modificar sus nombres, apellidos, DNI, correo institucional, teléfonos o fotografía, debe realizarlo directamente en el <strong>CRUD de Profesores</strong>.
                            </p>
                        </div>
                    </div>
                    @if ($user->teacher)
                        <div class="flex-shrink-0">
                            <a href="{{ route('teachers.edit', $user->teacher) }}" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Editar en CRUD de Profesores</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Formulario Docente: Datos Bloqueados + Cambio/Restablecimiento de Contraseña (ÚNICO) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6 md:p-8">
                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Datos del Docente (Solo Lectura) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nombre Completo (Solo lectura) -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block font-medium text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Nombre Completo
                                    </label>
                                    <span class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold">
                                        (CRUD Profesores)
                                    </span>
                                </div>
                                <input type="text" value="{{ $user->name }}" readonly disabled class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-xl font-medium cursor-not-allowed">
                            </div>

                            <!-- DNI (Solo lectura) -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block font-medium text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        DNI
                                    </label>
                                    <span class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold">
                                        (CRUD Profesores)
                                    </span>
                                </div>
                                <input type="text" value="{{ $user->dni ?? ($user->teacher ? $user->teacher->dni : 'No registrado') }}" readonly disabled class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-xl font-mono cursor-not-allowed">
                            </div>

                            <!-- Correo Institucional de Acceso (Solo lectura) -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block font-medium text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Correo Electrónico de Acceso
                                    </label>
                                    <span class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold">
                                        (@sam.edu.pe)
                                    </span>
                                </div>
                                <input type="email" value="{{ $user->email }}" readonly disabled class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-xl font-mono cursor-not-allowed">
                            </div>

                            <!-- Rol en el Sistema (Solo lectura) -->
                            <div>
                                <label class="block font-medium text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                    Rol en el Sistema
                                </label>
                                <input type="text" value="Profesor / Docente" readonly disabled class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-blue-700 dark:text-blue-300 font-bold rounded-xl cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Sección de Restablecer Contraseña (ÚNICA) -->
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-2.5 mb-4">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                                    Restablecer / Actualizar Contraseña
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="password" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                        Nueva Contraseña <span class="text-xs text-gray-400 font-normal">(Mínimo 6 caracteres)</span>
                                    </label>
                                    <input id="password" name="password" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Ingrese la nueva contraseña">
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                        Confirmar Nueva Contraseña
                                    </label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Repita la nueva contraseña">
                                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end space-x-3">
                            <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                                Guardar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- Formulario Administrador: Edición Completa -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6 md:p-8">
                    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nombre Completo -->
                            <div>
                                <label for="name" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" required>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- DNI -->
                            <div>
                                <label for="dni" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    DNI <span class="text-xs text-gray-400 font-normal">(8 dígitos)</span>
                                </label>
                                <input id="dni" name="dni" type="text" value="{{ old('dni', $user->dni) }}" maxlength="20" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 font-mono">
                                <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                            </div>

                            <!-- Correo Electrónico -->
                            <div>
                                <label for="email" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Correo Electrónico de Acceso <span class="text-red-500">*</span>
                                </label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" required>
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Rol -->
                            <div>
                                <label for="role" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Rol en el Sistema <span class="text-red-500">*</span>
                                </label>
                                <select id="role" name="role" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100">
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Estudiante</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>

                            <!-- Nueva Contraseña (Opcional) -->
                            <div>
                                <label for="password" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Nueva Contraseña <span class="text-xs text-gray-400 font-normal">(Dejar en blanco para mantener la actual)</span>
                                </label>
                                <input id="password" name="password" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Nueva contraseña (opcional)">
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <!-- Confirmar Nueva Contraseña -->
                            <div>
                                <label for="password_confirmation" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input id="password_confirmation" name="password_confirmation" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Repita la nueva contraseña">
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end space-x-3">
                            <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
