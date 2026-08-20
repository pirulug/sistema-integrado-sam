<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de Módulo EFSRT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header Actions -->
                    <div class="flex items-center justify-between pb-6 border-b border-gray-200 dark:border-gray-700 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg">
                                EF
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">{{ $efsrt->module }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $efsrt->module_name ?? 'Sin nombre de módulo' }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('efsrts.edit', $efsrt) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                Editar
                            </a>
                            <a href="{{ route('efsrts.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Volver
                            </a>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Module Info -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Información del Módulo</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Identificador</span>
                                    <span class="text-sm font-semibold">{{ $efsrt->module }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Nombre del Módulo</span>
                                    <span class="text-sm font-semibold">{{ $efsrt->module_name ?? 'No especificado' }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Periodo Académico</span>
                                    <span class="text-sm font-semibold">{{ $efsrt->period ? 'Periodo ' . $efsrt->period : 'No especificado' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Hours & Credits -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Carga Horaria y Créditos</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Total Horas Requeridas</span>
                                    <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">{{ $efsrt->hours ? $efsrt->hours . ' horas' : 'No especificado' }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Créditos Académicos</span>
                                    <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">{{ $efsrt->credits ? $efsrt->credits . ' créditos' : 'No especificado' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Associated Curriculums -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Mallas Curriculares</h4>
                            @if ($efsrt->curriculums->isEmpty())
                                <p class="text-sm text-gray-500 dark:text-gray-400">Este módulo EFSRT no está asociado a ninguna malla curricular actualmente.</p>
                            @else
                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($efsrt->curriculums as $curriculum)
                                        <li class="py-2 flex justify-between items-center">
                                            <span class="text-sm font-semibold">{{ $curriculum->name }}</span>
                                            <span class="text-xs bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 px-2.5 py-0.5 rounded-full">{{ $curriculum->year }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Competency Section -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-lg border border-gray-100 dark:border-gray-800 mb-6">
                        <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-2">Competencias por Módulo Formativo</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $efsrt->competency ?? 'No se ha registrado una descripción de competencia para este módulo.' }}
                        </p>
                    </div>

                    <!-- Practice Lines and Activities Section -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-lg border border-gray-100 dark:border-gray-800">
                        <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Líneas de Práctica y Actividades</h4>
                        @if (empty($efsrt->practice_lines) || !is_array($efsrt->practice_lines))
                            <p class="text-sm text-gray-500 dark:text-gray-400">No se han registrado líneas de práctica específicas para este módulo.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($efsrt->practice_lines as $index => $item)
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold flex items-center justify-center">
                                                {{ $index + 1 }}
                                            </span>
                                            <h5 class="font-bold text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item['line'] ?? $item['name'] ?? 'Línea de Práctica' }}
                                            </h5>
                                        </div>
                                        @if (!empty($item['activities']) && is_array($item['activities']))
                                            <ul class="ms-8 list-disc text-xs text-gray-600 dark:text-gray-300 space-y-1 mt-2">
                                                @foreach ($item['activities'] as $act)
                                                    <li>{{ $act }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
