<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('EFSRT (Módulos de Prácticas)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded dark:bg-green-900/30 dark:text-green-400" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between pb-6 space-y-4 md:space-y-0 gap-4">
                        <!-- Search & Filter Form -->
                        <form method="GET" action="{{ route('efsrts.index') }}" class="w-full md:w-2/3 flex flex-wrap sm:flex-nowrap items-center gap-3">
                            <!-- Plan Filter Dropdown -->
                            <select name="curriculum_id" onchange="this.form.submit()" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-xs shadow-sm py-2">
                                <option value="">-- Todos los Planes / Mallas --</option>
                                @foreach ($curriculums as $c)
                                    <option value="{{ $c->id }}" {{ $curriculumId == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->year }})</option>
                                @endforeach
                            </select>

                            <!-- Text Search Input -->
                            <div class="relative flex-grow">
                                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por Módulo, Nombre o Competencia..." class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-xs shadow-sm py-2" />
                            </div>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 focus:outline-none transition">
                                Buscar
                            </button>

                            @if ($search || $curriculumId)
                                <a href="{{ route('efsrts.index') }}" class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 underline whitespace-nowrap">
                                    Limpiar
                                </a>
                            @endif
                        </form>

                        <!-- Add Button -->
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('efsrts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition shadow-md whitespace-nowrap">
                                Registrar Módulo EFSRT
                            </a>
                        @endif
                    </div>

                    <!-- EFSRTs Grouped Table -->
                    @if ($efsrts->isEmpty())
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            No se encontraron módulos EFSRT.
                        </div>
                    @else
                        @php
                            $grouped = $efsrts->groupBy(function($item) {
                                if ($item->curriculums->isNotEmpty()) {
                                    return $item->curriculums->pluck('name')->join(', ');
                                }
                                if (str_contains($item->module, '2020')) return 'Malla Curricular 2020';
                                if (str_contains($item->module, '2019')) return 'Malla Curricular 2019';
                                return 'Módulos Generales / Sin Malla Asignada';
                            });
                        @endphp

                        <div class="space-y-6">
                            @foreach ($grouped as $groupName => $items)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm">
                                    <!-- Group Header -->
                                    <div class="bg-gray-50 dark:bg-gray-900/70 px-6 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="w-3 h-3 rounded-full {{ str_contains($groupName, '2020') ? 'bg-indigo-500' : (str_contains($groupName, '2019') ? 'bg-purple-500' : 'bg-emerald-500') }}"></span>
                                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                {{ $groupName }}
                                            </h3>
                                        </div>
                                        <span class="text-xs bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold px-2.5 py-0.5 rounded-full">
                                            {{ $items->count() }} módulos formativos
                                        </span>
                                    </div>

                                    <!-- Table -->
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-white dark:bg-gray-800">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Módulo</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre del Módulo (Práctica)</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Periodo</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Horas / Créditos</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Líneas de Práctica</th>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach ($items as $efsrt)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ str_contains($efsrt->module, '2020') ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950/70 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800' : 'bg-purple-100 text-purple-800 dark:bg-purple-950/70 dark:text-purple-300 border border-purple-200 dark:border-purple-800' }}">
                                                                    {{ $efsrt->module }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 font-medium">
                                                            {{ $efsrt->module_name ?? 'Sin nombre personalizado' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                                Periodo {{ $efsrt->period ?? '-' }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                            <div class="font-bold text-gray-900 dark:text-gray-100">{{ $efsrt->hours ? $efsrt->hours . ' hrs' : '-' }}</div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $efsrt->credits ? $efsrt->credits . ' créditos' : '-' }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                                            @if (!empty($efsrt->practice_lines) && is_array($efsrt->practice_lines))
                                                                <span class="inline-flex items-center text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-md font-medium">
                                                                    {{ count($efsrt->practice_lines) }} líneas formativas
                                                                </span>
                                                            @else
                                                                <span class="text-xs text-gray-400">No registradas</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-3">
                                                            <a href="{{ route('efsrts.show', $efsrt) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold">Ver</a>
                                                            @if (Auth::user()->isAdmin())
                                                                <a href="{{ route('efsrts.edit', $efsrt) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 font-semibold">Editar</a>
                                                                <form action="{{ route('efsrts.destroy', $efsrt) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este módulo EFSRT?');">
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
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $efsrts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
