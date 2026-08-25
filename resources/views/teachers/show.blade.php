<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perfil del Profesor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header Actions -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-gray-200 dark:border-gray-700 mb-6 gap-4">
                        <div class="flex items-center space-x-4">
                            @if ($teacher->photo_url)
                                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500 shadow-md">
                            @else
                                <div class="w-16 h-16 bg-gradient-to-tr from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center font-bold text-xl shadow-md">
                                    {{ strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->paternal_last_name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-xl font-bold">{{ $teacher->full_name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 dark:bg-indigo-900/60 text-indigo-800 dark:text-indigo-300">
                                        Docente
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                                        {{ $teacher->teacher_code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('teachers.edit', $teacher) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                Editar
                            </a>
                            <a href="{{ route('teachers.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Volver
                            </a>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Info -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Información Personal</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">DNI</span>
                                    <span class="text-sm font-semibold font-mono">{{ $teacher->dni }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Código de Profesor</span>
                                    <span class="text-sm font-semibold font-mono">{{ $teacher->teacher_code }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Nombres</span>
                                    <span class="text-sm font-semibold">{{ $teacher->first_name }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Apellido Paterno</span>
                                    <span class="text-sm font-semibold">{{ $teacher->paternal_last_name }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Apellido Materno</span>
                                    <span class="text-sm font-semibold">{{ $teacher->maternal_last_name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Professional Info -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Contacto y Contratación</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Email Institucional</span>
                                    <span class="text-sm font-semibold break-all text-indigo-600 dark:text-indigo-400">{{ $teacher->institutional_email }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Email Personal</span>
                                    <span class="text-sm font-semibold break-all">{{ $teacher->personal_email ?? '-' }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Teléfono</span>
                                        <span class="text-sm font-semibold">{{ $teacher->phone ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Celular</span>
                                        <span class="text-sm font-semibold">{{ $teacher->mobile ?? '-' }}</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Fecha de Contratación</span>
                                    <span class="text-sm font-semibold">{{ $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('d/m/Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Account Card (Admin View) -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="p-5 rounded-2xl border {{ $teacher->user ? 'bg-emerald-50/50 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-800/60' : 'bg-amber-50/50 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800/60' }}">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2.5 rounded-xl {{ $teacher->user ? 'bg-emerald-100 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-900/60 text-amber-700 dark:text-amber-300' }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $teacher->user ? 'Cuenta de Usuario Asignada' : 'Sin Cuenta de Acceso' }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            @if ($teacher->user)
                                                Usuario: <strong class="text-gray-800 dark:text-gray-200">{{ $teacher->user->email }}</strong> (Rol: {{ ucfirst($teacher->user->role) }})
                                            @else
                                                Este profesor no tiene credenciales para ingresar al sistema.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($teacher->user)
                                        <a href="{{ route('users.edit', $teacher->user) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                            Restablecer Contraseña
                                        </a>
                                    @else
                                        <a href="{{ route('users.create', ['teacher_id' => $teacher->id, 'role' => 'teacher']) }}" class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                            Crear Cuenta de Usuario
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
