<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2.5">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Perfil de Usuario: {{ $user->name }}</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Información detallada de la cuenta, vinculación académica y credenciales de acceso.
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Editar</span>
                </a>
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-3.5 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl text-xs font-bold shadow-sm transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Volver</span>
                </a>
            </div>
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

            <!-- Main Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6 md:p-8">
                <!-- User Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-gray-200 dark:border-gray-700 gap-4 mb-6">
                    <div class="flex items-center space-x-4">
                        @if ($user->photo_url)
                            <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500 shadow-md flex-shrink-0">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xl shadow-md flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5 font-mono">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div>
                        @if ($user->role === 'admin')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                Administrador
                            </span>
                        @elseif ($user->role === 'teacher')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                Profesor / Docente
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                {{ ucfirst($user->role) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Grid Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">ID de Usuario</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white font-mono">#{{ $user->id }}</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Documento de Identidad (DNI)</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white font-mono">{{ $user->dni ?? 'No registrado' }}</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Correo Electrónico</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->email }}</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Fecha de Registro</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Perfil Docente Asociado</span>
                            @if ($user->teacher)
                                <div class="mt-1 p-3 bg-blue-50/70 dark:bg-blue-950/30 rounded-xl border border-blue-200 dark:border-blue-800/60">
                                    <div class="text-xs font-bold text-blue-900 dark:text-blue-200">{{ $user->teacher->full_name }}</div>
                                    <div class="text-[11px] text-blue-700 dark:text-blue-300 font-mono mt-0.5">
                                        Código: {{ $user->teacher->teacher_code }} &bull; DNI: {{ $user->teacher->dni }}
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('teachers.show', $user->teacher) }}" class="text-[11px] text-blue-600 hover:underline font-bold">
                                            Ver expediente del docente &rarr;
                                        </a>
                                    </div>
                                </div>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400 italic">Sin perfil docente vinculado</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Restablecer Contraseña -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-amber-200 dark:border-amber-900/60 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-amber-100 dark:bg-amber-900/50 rounded-xl text-amber-600 dark:text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Restablecer Contraseña de este Usuario</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Establezca una nueva clave de acceso si el usuario olvidó sus credenciales.
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('users.reset-password', $user) }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    @csrf
                    <div>
                        <label for="reset_password_show" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                            Nueva Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input id="reset_password_show" name="password" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 text-gray-900 dark:text-gray-100" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <div>
                        <label for="reset_password_confirmation_show" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                            Confirmar Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input id="reset_password_confirmation_show" name="password_confirmation" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 text-gray-900 dark:text-gray-100" placeholder="Repita la contraseña" required>
                    </div>
                    <div>
                        <button type="submit" class="w-full py-2.5 px-4 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-md shadow-amber-500/20 transition">
                            Restablecer Clave
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
