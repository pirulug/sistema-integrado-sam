<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2.5">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Registro de Auditoría y Seguimiento de Cambios</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Historial cronológico completo de modificaciones, creaciones, eliminaciones y operaciones del sistema.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Solo Administradores
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{
        modalOpen: false,
        activeLog: null,
        rawJsonOpen: false,
        openModal(log) {
            this.activeLog = log;
            this.rawJsonOpen = false;
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
            this.activeLog = null;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- KPI Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Logs -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total de Eventos</span>
                        <div class="p-2.5 bg-indigo-50 dark:bg-indigo-950/50 rounded-xl text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6m-6 4h6m-6 4h4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($totalLogs) }}</div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Registros acumulados en el historial</span>
                    </div>
                </div>

                <!-- Today Logs -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-emerald-200 dark:border-emerald-900/60">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Actividad de Hoy</span>
                        <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/50 rounded-xl text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-emerald-700 dark:text-emerald-300">{{ number_format($todayLogs) }}</div>
                        <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">Eventos registrados hoy</span>
                    </div>
                </div>

                <!-- Deletions -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-rose-200 dark:border-rose-900/60">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Eliminaciones</span>
                        <div class="p-2.5 bg-rose-50 dark:bg-rose-950/50 rounded-xl text-rose-600 dark:text-rose-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-3xl font-black text-rose-700 dark:text-rose-300">{{ number_format($deletionsCount) }}</div>
                        <span class="text-[11px] text-rose-600 dark:text-rose-400 font-medium">Acciones de eliminación totales</span>
                    </div>
                </div>

                <!-- Top Module -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-amber-200 dark:border-amber-900/60">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Módulo Más Activo</span>
                        <div class="p-2.5 bg-amber-50 dark:bg-amber-950/50 rounded-xl text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-xl font-black text-amber-800 dark:text-amber-300 truncate" title="{{ $topModuleName }}">{{ $topModuleName }}</div>
                        <span class="text-[11px] text-amber-600 dark:text-amber-400 font-medium">Mayor volumen de modificaciones</span>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80">
                <form method="GET" action="{{ route('activity-logs.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                        <!-- Search Box -->
                        <div>
                            <label for="search_input" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                Búsqueda Libre
                            </label>
                            <div class="relative">
                                <input type="text" id="search_input" name="search" value="{{ $search }}" placeholder="Descripción, nombre o DNI..." class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 pl-8 shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Module Filter -->
                        <div>
                            <label for="module_select" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                Módulo
                            </label>
                            <select id="module_select" name="module" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                <option value="">-- Todos los Módulos --</option>
                                @foreach ($modules as $mod)
                                    <option value="{{ $mod }}" {{ $module === $mod ? 'selected' : '' }}>{{ $mod }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Filter -->
                        <div>
                            <label for="action_select" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                Tipo de Acción
                            </label>
                            <select id="action_select" name="action" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                <option value="">-- Todas las Acciones --</option>
                                @foreach ($actions as $actKey => $actLabel)
                                    <option value="{{ $actKey }}" {{ $action === $actKey ? 'selected' : '' }}>{{ $actLabel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- User Filter -->
                        <div>
                            <label for="user_select" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                Usuario Responsable
                            </label>
                            <select id="user_select" name="user_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                <option value="">-- Todos los Usuarios --</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" {{ (string)$userId === (string)$u->id ? 'selected' : '' }}>
                                        {{ $u->name }} ({{ $u->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range Preset -->
                        <div>
                            <label for="date_range_select" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                Periodo
                            </label>
                            <select id="date_range_select" name="date_range" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                <option value="all" {{ $dateRange === 'all' ? 'selected' : '' }}>Historial Completo</option>
                                <option value="today" {{ $dateRange === 'today' ? 'selected' : '' }}>Hoy</option>
                                <option value="yesterday" {{ $dateRange === 'yesterday' ? 'selected' : '' }}>Ayer</option>
                                <option value="this_week" {{ $dateRange === 'this_week' ? 'selected' : '' }}>Esta Semana</option>
                                <option value="this_month" {{ $dateRange === 'this_month' ? 'selected' : '' }}>Este Mes</option>
                                <option value="last_30_days" {{ $dateRange === 'last_30_days' ? 'selected' : '' }}>Últimos 30 Días</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                        @if ($search || $module || $action || $userId || ($dateRange && $dateRange !== 'all'))
                            <a href="{{ route('activity-logs.index') }}" class="px-3.5 py-1.5 text-xs text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-semibold transition">
                                Limpiar Filtros
                            </a>
                        @endif
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>Aplicar Filtros</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Activity Logs Table Container -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="px-5 py-3.5 text-left">Fecha y Hora</th>
                                <th scope="col" class="px-5 py-3.5 text-left">Usuario Responsable</th>
                                <th scope="col" class="px-5 py-3.5 text-left">Módulo</th>
                                <th scope="col" class="px-5 py-3.5 text-left">Acción</th>
                                <th scope="col" class="px-5 py-3.5 text-left">Elemento Afectado</th>
                                <th scope="col" class="px-5 py-3.5 text-left">Descripción del Evento</th>
                                <th scope="col" class="px-5 py-3.5 text-center">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700/60 text-xs">
                            @forelse ($logs as $log)
                                @php
                                    $actionColors = [
                                        'created' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800',
                                        'updated' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800',
                                        'deleted' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800',
                                        'imported' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/50 dark:text-blue-300 dark:border-blue-800',
                                        'toggle_course' => 'bg-teal-50 text-teal-700 border-teal-200 dark:bg-teal-950/50 dark:text-teal-300 dark:border-teal-800',
                                        'bulk_courses' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/50 dark:text-indigo-300 dark:border-indigo-800',
                                        'update_efsrt' => 'bg-cyan-50 text-cyan-700 border-cyan-200 dark:bg-cyan-950/50 dark:text-cyan-300 dark:border-cyan-800',
                                        'degree_update' => 'bg-purple-50 text-purple-700 border-purple-200 dark:bg-purple-950/50 dark:text-purple-300 dark:border-purple-800',
                                        'degree_reverted' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/50 dark:text-red-300 dark:border-red-800',
                                        'password_reset' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-950/50 dark:text-orange-300 dark:border-orange-800',
                                        'conflict_resolution' => 'bg-violet-50 text-violet-700 border-violet-200 dark:bg-violet-950/50 dark:text-violet-300 dark:border-violet-800',
                                    ];
                                    $badgeClass = $actionColors[$log->action] ?? 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700';
                                    $actionLabel = $actions[$log->action] ?? ucfirst($log->action);
                                @endphp
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition">
                                    <!-- Timestamp -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900 dark:text-gray-100">
                                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 dark:text-gray-500">
                                            {{ $log->created_at->diffForHumans() }}
                                        </div>
                                    </td>

                                    <!-- User -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xs font-bold shrink-0 shadow-sm">
                                                {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $log->user_name ?? 'Sistema' }}
                                                </div>
                                                <div class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                                    <span>{{ $log->user_role ? strtoupper($log->user_role) : 'N/A' }}</span>
                                                    @if ($log->ip_address)
                                                        <span class="text-gray-300 dark:text-gray-600">•</span>
                                                        <span class="font-mono text-[10px]">{{ $log->ip_address }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Module -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg font-semibold text-[11px] bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                            {{ $log->module }}
                                        </span>
                                    </td>

                                    <!-- Action -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg font-bold text-[11px] border {{ $badgeClass }}">
                                            {{ $actionLabel }}
                                        </span>
                                    </td>

                                    <!-- Subject Label -->
                                    <td class="px-5 py-4 max-w-[200px] truncate" title="{{ $log->subject_label }}">
                                        <span class="font-medium text-gray-900 dark:text-gray-200">
                                            {{ $log->subject_label ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- Description -->
                                    <td class="px-5 py-4 max-w-[320px]">
                                        <div class="text-gray-700 dark:text-gray-300 font-medium line-clamp-2" title="{{ $log->description }}">
                                            {{ $log->description }}
                                        </div>
                                    </td>

                                    <!-- Action Button -->
                                    <td class="px-5 py-4 whitespace-nowrap text-center">
                                        <button type="button" @click='openModal(@json($log))' class="inline-flex items-center px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/60 dark:hover:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 rounded-lg text-xs font-bold border border-indigo-200 dark:border-indigo-800 transition shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Detalle</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="font-bold text-sm text-gray-700 dark:text-gray-300">No se encontraron registros de auditoría</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Pruebe modificando los filtros o el rango de fechas seleccionado.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                @if ($logs->hasPages())
                    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Alpine.js Detail & Diff Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background backdrop -->
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-xs" @click="closeModal()" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200 dark:border-gray-700">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-gray-900 dark:text-white" id="modal-title">
                                    Detalle del Evento de Auditoría
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="'Registro #' + (activeLog ? activeLog.id : '')"></p>
                            </div>
                        </div>
                        <button type="button" @click="closeModal()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <template x-if="activeLog">
                        <div class="py-4 space-y-5 text-xs">
                            <!-- Information Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 bg-gray-50 dark:bg-gray-900/60 p-4 rounded-xl border border-gray-200 dark:border-gray-700/60">
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Módulo</span>
                                    <span class="font-bold text-gray-900 dark:text-white text-xs mt-0.5 block" x-text="activeLog.module"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Acción Realizada</span>
                                    <span class="font-bold text-indigo-600 dark:text-indigo-400 text-xs mt-0.5 block" x-text="activeLog.action"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Fecha y Hora</span>
                                    <span class="font-bold text-gray-900 dark:text-white text-xs mt-0.5 block" x-text="new Date(activeLog.created_at).toLocaleString('es-PE')"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Usuario Responsable</span>
                                    <span class="font-semibold text-gray-900 dark:text-white text-xs mt-0.5 block" x-text="activeLog.user_name || 'Sistema'"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Dirección IP</span>
                                    <span class="font-mono text-gray-700 dark:text-gray-300 text-xs mt-0.5 block" x-text="activeLog.ip_address || 'No registrada'"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Elemento</span>
                                    <span class="font-semibold text-gray-900 dark:text-white text-xs mt-0.5 block truncate" x-text="activeLog.subject_label || '-'"></span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h4 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">
                                    Descripción Completa
                                </h4>
                                <div class="p-3 bg-indigo-50/60 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/60 rounded-xl text-gray-800 dark:text-gray-200 font-medium leading-relaxed" x-text="activeLog.description"></div>
                            </div>

                            <!-- Value Differences (Diff Table) -->
                            <div>
                                <h4 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2 flex items-center justify-between">
                                    <span>Comparativa de Atributos (Valores Anteriores vs. Nuevos)</span>
                                </h4>

                                <!-- When there are old or new values -->
                                <template x-if="activeLog.old_values || activeLog.new_values">
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-xs">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                                            <thead class="bg-gray-100 dark:bg-gray-900 font-bold text-gray-700 dark:text-gray-300 uppercase text-[10px]">
                                                <tr>
                                                    <th class="px-4 py-2.5 text-left w-1/4">Campo</th>
                                                    <th class="px-4 py-2.5 text-left w-3/8">Valor Anterior</th>
                                                    <th class="px-4 py-2.5 text-left w-3/8">Valor Nuevo</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                                                @php
                                                    // Dynamic JS template handles looping keys
                                                @endphp
                                                <template x-for="key in Array.from(new Set([...Object.keys(activeLog.old_values || {}), ...Object.keys(activeLog.new_values || {})]))" :key="key">
                                                    <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30">
                                                        <td class="px-4 py-2.5 font-bold font-mono text-gray-800 dark:text-gray-200" x-text="key"></td>
                                                        <td class="px-4 py-2.5 bg-red-50/50 dark:bg-red-950/20 text-red-900 dark:text-red-300 font-medium break-all" x-text="activeLog.old_values && activeLog.old_values[key] !== undefined ? (typeof activeLog.old_values[key] === 'object' ? JSON.stringify(activeLog.old_values[key]) : activeLog.old_values[key]) : '-'"></td>
                                                        <td class="px-4 py-2.5 bg-emerald-50/50 dark:bg-emerald-950/20 text-emerald-900 dark:text-emerald-300 font-medium break-all" x-text="activeLog.new_values && activeLog.new_values[key] !== undefined ? (typeof activeLog.new_values[key] === 'object' ? JSON.stringify(activeLog.new_values[key]) : activeLog.new_values[key]) : '-'"></td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>

                                <template x-if="!activeLog.old_values && !activeLog.new_values">
                                    <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl text-center text-gray-500 dark:text-gray-400 font-medium text-xs">
                                        No se registraron cambios estructurales o diferencias de campos en este evento.
                                    </div>
                                </template>
                            </div>

                            <!-- Raw JSON Accordion -->
                            <div class="pt-2">
                                <button type="button" @click="rawJsonOpen = !rawJsonOpen" class="inline-flex items-center text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">
                                    <svg class="w-4 h-4 mr-1 transition-transform" :class="{'rotate-90': rawJsonOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    <span x-text="rawJsonOpen ? 'Ocultar Carga JSON Completa' : 'Ver Carga JSON Completa'"></span>
                                </button>
                                <div x-show="rawJsonOpen" class="mt-2 p-3 bg-gray-900 text-gray-100 rounded-xl font-mono text-[11px] overflow-x-auto max-h-48 border border-gray-800">
                                    <pre x-text="JSON.stringify(activeLog, null, 2)"></pre>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="closeModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold text-xs rounded-xl transition">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
