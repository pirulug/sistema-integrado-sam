<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Curso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('courses.update', $course) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Code -->
                            <div>
                                <x-input-label for="code" :value="__('Código del Curso')" />
                                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $course->code)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('code')" />
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Nombre del Curso')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $course->name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Period -->
                            <div>
                                <x-input-label for="period" :value="__('Periodo Académico (Semestre)')" />
                                <select id="period" name="period" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">Seleccione Periodo</option>
                                    <option value="I" {{ old('period', $course->period) == 'I' ? 'selected' : '' }}>I</option>
                                    <option value="II" {{ old('period', $course->period) == 'II' ? 'selected' : '' }}>II</option>
                                    <option value="III" {{ old('period', $course->period) == 'III' ? 'selected' : '' }}>III</option>
                                    <option value="IV" {{ old('period', $course->period) == 'IV' ? 'selected' : '' }}>IV</option>
                                    <option value="V" {{ old('period', $course->period) == 'V' ? 'selected' : '' }}>V</option>
                                    <option value="VI" {{ old('period', $course->period) == 'VI' ? 'selected' : '' }}>VI</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('period')" />
                            </div>

                            <!-- Credits -->
                            <div>
                                <x-input-label for="credits" :value="__('Créditos')" />
                                <x-text-input id="credits" name="credits" type="number" class="mt-1 block w-full" :value="old('credits', $course->credits)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('credits')" />
                            </div>

                            <!-- Hours -->
                            <div>
                                <x-input-label for="hours" :value="__('Horas Académicas')" />
                                <x-text-input id="hours" name="hours" type="number" class="mt-1 block w-full" :value="old('hours', $course->hours)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hours')" />
                            </div>

                            <!-- Curriculums Selection (Pivot) -->
                            <div class="md:col-span-2">
                                <x-input-label :value="__('Asociar a Mallas Curriculares')" />
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($curriculums->isEmpty())
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No hay mallas creadas aún.</p>
                                    @else
                                        @foreach($curriculums as $curriculum)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="curriculums[]" value="{{ $curriculum->id }}" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ (is_array(old('curriculums')) && in_array($curriculum->id, old('curriculums'))) || (!is_array(old('curriculums')) && $course->curriculums->contains($curriculum->id)) ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $curriculum->name }} ({{ $curriculum->year }})</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('curriculums')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
