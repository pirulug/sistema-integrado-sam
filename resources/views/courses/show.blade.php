<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Curso') }}
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
                                {{ strtoupper(substr($course->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">{{ $course->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Código: {{ $course->code }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                    Editar
                                </a>
                            @endif
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Volver
                            </a>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Technical Info -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Información del Curso</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Código Único</span>
                                    <span class="text-sm font-semibold">{{ $course->code }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block">Nombre</span>
                                    <span class="text-sm font-semibold">{{ $course->name }}</span>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Periodo</span>
                                        <span class="text-sm font-semibold">Semestre {{ $course->period }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Créditos</span>
                                        <span class="text-sm font-semibold">{{ $course->credits }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Horas Académicas</span>
                                        <span class="text-sm font-semibold">{{ $course->hours }} h</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Associated Curriculums -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                            <h4 class="font-bold text-sm text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Mallas Curriculares Asociadas</h4>
                            @if ($course->curriculums->isEmpty())
                                <p class="text-sm text-gray-500 dark:text-gray-400">Este curso no pertenece a ninguna malla curricular actualmente.</p>
                            @else
                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($course->curriculums as $curriculum)
                                        <li class="py-2 flex justify-between items-center">
                                            <span class="text-sm font-semibold">{{ $curriculum->name }}</span>
                                            <span class="text-xs bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 px-2.5 py-0.5 rounded-full">{{ $curriculum->year }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
