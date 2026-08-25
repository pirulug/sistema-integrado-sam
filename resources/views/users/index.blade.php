<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2.5">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Gestión de Usuarios del Sistema</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Administración de cuentas de acceso, roles (Administrador, Auditor, Profesor) y credenciales.
                </p>
            </div>
            @if (Auth::user()->isAdmin())
                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span>Nuevo Usuario</span>
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8" x-data="{
        resetModalOpen: false,
        resetUserId: null,
        resetUserName: '',
        resetUserEmail: '',
        openResetModal(id, name, email) {
            this.resetUserId = id;
            this.resetUserName = name;
            this.resetUserEmail = email;
            this.resetModalOpen = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alerts -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-800 dark:text-emerald-300 text-sm font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 rounded-xl text-red-800 dark:text-red-300 text-sm font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
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

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Total Usuarios -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Usuarios</span>
                        <div class="p-2.5 bg-indigo-50 dark:bg-indigo-950/50 rounded-xl text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalUsers }}</div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Cuentas activas en la BD</span>
                    </div>
                </div>

                <!-- Administradores -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-purple-200 dark:border-purple-900/60">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Administradores</span>
                        <div class="p-2.5 bg-purple-50 dark:bg-purple-950/50 rounded-xl text-purple-600 dark:text-purple-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-purple-700 dark:text-purple-300">{{ $totalAdmins }}</div>
                        <span class="text-[11px] text-purple-600 dark:text-purple-400 font-medium">Acceso total al sistema</span>
                    </div>
                </div>

                <!-- Auditores / Observadores -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-teal-200 dark:border-teal-900/60">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider">Auditores</span>
                        <div class="p-2.5 bg-teal-50 dark:bg-teal-950/50 rounded-xl text-teal-600 dark:text-teal-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-teal-700 dark:text-teal-300">{{ $totalAuditors }}</div>
                        <span class="text-[11px] text-teal-600 dark:text-teal-400 font-medium">Solo lectura y logs</span>
                    </div>
                </div>

                <!-- Docentes con Usuario -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-emerald-200 dark:border-emerald-900/60">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Docentes con Acceso</span>
                        <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/50 rounded-xl text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-emerald-700 dark:text-emerald-300">{{ $totalTeachersWithUser }}</div>
                        <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">@sam.edu.pe</span>
                    </div>
                </div>

                <!-- Docentes sin Usuario -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-amber-200 dark:border-amber-900/60">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Docentes sin Usuario</span>
                        <div class="p-2.5 bg-amber-50 dark:bg-amber-950/50 rounded-xl text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-amber-700 dark:text-amber-300">{{ $totalTeachersWithoutUser }}</div>
                        @if ($totalTeachersWithoutUser > 0 && Auth::user()->isAdmin())
                            <a href="{{ route('users.create', ['role' => 'teacher']) }}" class="text-[11px] text-amber-600 hover:underline font-semibold flex items-center mt-0.5">
                                <span>Asignar pendientes</span>
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Docentes al día</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                    <div class="sm:col-span-6 relative">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre, correo o DNI..." class="w-full pl-10 pr-4 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 placeholder-gray-400">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <select name="role" class="w-full py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100">
                            <option value="">Todos los roles</option>
                            <option value="admin" {{ $roleFilter === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="auditor" {{ $roleFilter === 'auditor' ? 'selected' : '' }}>Auditor / Observador</option>
                            <option value="teacher" {{ $roleFilter === 'teacher' ? 'selected' : '' }}>Profesor / Docente</option>
                            <option value="student" {{ $roleFilter === 'student' ? 'selected' : '' }}>Estudiante</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2 flex space-x-2">
                        <button type="submit" class="w-full py-2 px-4 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-xl text-xs font-bold transition">
                            Filtrar
                        </button>
                        @if ($search || $roleFilter)
                            <a href="{{ route('users.index') }}" class="py-2 px-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold transition flex items-center justify-center" title="Limpiar filtros">
                                ✕
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuario</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Correo de Acceso</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">DNI</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rol</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Perfil Vinculado</th>
                                <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $u)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <!-- Usuario -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            @if ($u->photo_url)
                                                <img src="{{ $u->photo_url }}" alt="{{ $u->name }}" class="w-10 h-10 rounded-full object-cover border border-indigo-200 dark:border-indigo-800 shadow-sm flex-shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-sm flex-shrink-0">
                                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                    <span>{{ $u->name }}</span>
                                                    @if ($u->id === auth()->id())
                                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300">Tú</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-400 font-mono">ID: #{{ $u->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Correo de Acceso -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $u->email }}</div>
                                        @if (str_ends_with($u->email, '@sam.edu.pe'))
                                            <span class="inline-flex items-center text-[10px] font-semibold text-emerald-600 dark:text-emerald-400">
                                                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Institucional @sam.edu.pe
                                            </span>
                                        @endif
                                    </td>

                                    <!-- DNI -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700 dark:text-gray-300">
                                        {{ $u->dni ?? '-' }}
                                    </td>

                                    <!-- Rol -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($u->role === 'admin')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                                Administrador
                                            </span>
                                        @elseif ($u->role === 'auditor')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-800">
                                                Auditor
                                            </span>
                                        @elseif ($u->role === 'teacher')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                Profesor
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                {{ ucfirst($u->role) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Perfil Vinculado -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        @if ($u->teacher)
                                            <div class="font-semibold text-gray-800 dark:text-gray-200">{{ $u->teacher->full_name }}</div>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                Cód: {{ $u->teacher->teacher_code }}
                                            </span>
                                        @elseif ($u->role === 'admin')
                                            <span class="text-gray-400 italic">Administrador del Sistema</span>
                                        @elseif ($u->role === 'auditor')
                                            <span class="text-teal-600 dark:text-teal-400 italic font-medium">Auditor / Observador</span>
                                        @else
                                            <span class="text-amber-600 dark:text-amber-400 font-medium">Sin perfil asignado</span>
                                        @endif
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                        @if (Auth::user()->isAdmin())
                                            <!-- Botón Restablecer Contraseña -->
                                            <button type="button" @click="openResetModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}')" class="inline-flex items-center px-2.5 py-1 bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 hover:bg-amber-100 dark:hover:bg-amber-900/60 rounded-lg text-xs font-bold transition border border-amber-200 dark:border-amber-800" title="Restablecer contraseña">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                </svg>
                                                <span>Clave</span>
                                            </button>

                                            <a href="{{ route('users.edit', $u) }}" class="inline-flex items-center px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-100 rounded-lg text-xs font-bold transition border border-indigo-200 dark:border-indigo-800">
                                                Editar
                                            </a>

                                            @if ($u->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de que desea eliminar al usuario {{ addslashes($u->name) }}? Esta acción no se puede deshacer.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-300 hover:bg-red-100 rounded-lg text-xs font-bold transition border border-red-200 dark:border-red-800">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-400 italic">Solo lectura</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No se encontraron usuarios registrados con los criterios seleccionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Restablecer Contraseña -->
        @if (Auth::user()->isAdmin())
            <div x-show="resetModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/80" @click="resetModalOpen = false"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                    <div class="inline-block overflow-hidden text-left align-bottom bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                <span>Restablecer Contraseña</span>
                            </h3>
                            <button type="button" @click="resetModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                ✕
                            </button>
                        </div>

                        <form :action="'{{ url('users') }}/' + resetUserId + '/reset-password'" method="POST" class="mt-4 space-y-4">
                            @csrf
                            <div class="p-3 bg-amber-50 dark:bg-amber-950/30 rounded-xl border border-amber-200 dark:border-amber-800/60 text-xs text-amber-800 dark:text-amber-300">
                                Establecerá una nueva clave de acceso para el usuario <strong x-text="resetUserName"></strong> (<span class="font-mono" x-text="resetUserEmail"></span>).
                            </div>

                            <div>
                                <label for="reset_password" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Nueva Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="reset_password" name="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 text-gray-900 dark:text-gray-100" placeholder="Mínimo 6 caracteres" required>
                            </div>

                            <div>
                                <label for="reset_password_confirmation" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                    Confirmar Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="reset_password_confirmation" name="password_confirmation" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 text-gray-900 dark:text-gray-100" placeholder="Repita la nueva contraseña" required>
                            </div>

                            <div class="flex items-center justify-end space-x-3 pt-3">
                                <button type="button" @click="resetModalOpen = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold transition">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-md transition">
                                    Guardar Nueva Clave
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
