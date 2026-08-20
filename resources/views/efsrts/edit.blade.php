<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Módulo EFSRT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('efsrts.update', $efsrt) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Module -->
                            <div>
                                <x-input-label for="module" :value="__('Identificador del Módulo')" />
                                <x-text-input id="module" name="module" type="text" class="mt-1 block w-full" :value="old('module', $efsrt->module)" required autofocus placeholder="ej. Módulo I" />
                                <x-input-error class="mt-2" :messages="$errors->get('module')" />
                            </div>

                            <!-- Module Name -->
                            <div>
                                <x-input-label for="module_name" :value="__('Nombre del Módulo (Práctica)')" />
                                <x-text-input id="module_name" name="module_name" type="text" class="mt-1 block w-full" :value="old('module_name', $efsrt->module_name)" placeholder="ej. Diseño y elaboración de páginas web" />
                                <x-input-error class="mt-2" :messages="$errors->get('module_name')" />
                            </div>

                            <!-- Academic Period -->
                            <div>
                                <x-input-label for="period" :value="__('Periodo Académico')" />
                                <select id="period" name="period" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">-- Seleccionar Periodo --</option>
                                    @foreach(['I', 'II', 'III', 'IV', 'V', 'VI'] as $p)
                                        <option value="{{ $p }}" {{ old('period', $efsrt->period) == $p ? 'selected' : '' }}>Periodo {{ $p }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('period')" />
                            </div>

                            <!-- Hours & Credits in a subgrid -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="hours" :value="__('Total Horas')" />
                                    <x-text-input id="hours" name="hours" type="number" min="0" class="mt-1 block w-full" :value="old('hours', $efsrt->hours)" placeholder="ej. 96" />
                                    <x-input-error class="mt-2" :messages="$errors->get('hours')" />
                                </div>
                                <div>
                                    <x-input-label for="credits" :value="__('Créditos')" />
                                    <x-text-input id="credits" name="credits" type="number" min="0" class="mt-1 block w-full" :value="old('credits', $efsrt->credits)" placeholder="ej. 3" />
                                    <x-input-error class="mt-2" :messages="$errors->get('credits')" />
                                </div>
                            </div>

                            <!-- Competency Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="competency" :value="__('Competencias por Módulo Formativo')" />
                                <textarea id="competency" name="competency" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Descripción detallada de la competencia técnica a desarrollar...">{{ old('competency', $efsrt->competency) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('competency')" />
                            </div>

                            <!-- Practice Lines and Activities Builder -->
                            <div class="md:col-span-2">
                                <div class="flex items-center justify-between mb-2">
                                    <x-input-label :value="__('Líneas de Práctica y Actividades Formativas')" />
                                    <button type="button" id="btn-add-line" class="inline-flex items-center text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                        + Agregar Línea de Práctica
                                    </button>
                                </div>
                                <div id="practice-lines-container" class="space-y-4">
                                    <!-- Dynamic rows will be inserted here by JS -->
                                </div>
                                <input type="hidden" name="practice_lines" id="practice_lines_json" value="{{ is_array(old('practice_lines', $efsrt->practice_lines)) ? json_encode(old('practice_lines', $efsrt->practice_lines)) : old('practice_lines', json_encode($efsrt->practice_lines ?? [])) }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('practice_lines')" />
                            </div>

                            <!-- Curriculums Selection (Pivot) -->
                            <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <x-input-label :value="__('Asociar a Mallas Curriculares')" />
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($curriculums->isEmpty())
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No hay mallas creadas aún.</p>
                                    @else
                                        @foreach($curriculums as $curriculum)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="curriculums[]" value="{{ $curriculum->id }}" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" {{ (is_array(old('curriculums')) && in_array($curriculum->id, old('curriculums'))) || (!is_array(old('curriculums')) && $efsrt->curriculums->contains($curriculum->id)) ? 'checked' : '' }}>
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $curriculum->name }} ({{ $curriculum->year }})</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('curriculums')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('efsrts.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const container = document.getElementById("practice-lines-container");
                            const hiddenInput = document.getElementById("practice_lines_json");
                            const addLineBtn = document.getElementById("btn-add-line");

                            let linesData = [];
                            try {
                                const initialVal = hiddenInput.value;
                                linesData = typeof initialVal === "string" && initialVal ? JSON.parse(initialVal) : (Array.isArray(initialVal) ? initialVal : []);
                            } catch (e) {
                                linesData = [];
                            }

                            function renderLines() {
                                container.innerHTML = "";
                                if (linesData.length === 0) {
                                    container.innerHTML = '<p class="text-xs text-gray-400 italic">No hay líneas de práctica agregadas. Haga clic en "+ Agregar Línea de Práctica" para añadir una.</p>';
                                }

                                linesData.forEach((item, lIndex) => {
                                    const card = document.createElement("div");
                                    card.className = "p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 space-y-2";
                                    
                                    const headerDiv = document.createElement("div");
                                    headerDiv.className = "flex items-center justify-between";

                                    const titleLabel = document.createElement("span");
                                    titleLabel.className = "text-xs font-bold text-indigo-600 dark:text-indigo-400";
                                    titleLabel.textContent = "Línea de Práctica #" + (lIndex + 1);

                                    const deleteLineBtn = document.createElement("button");
                                    deleteLineBtn.type = "button";
                                    deleteLineBtn.className = "text-xs text-red-500 hover:text-red-700 font-semibold";
                                    deleteLineBtn.textContent = "Eliminar Línea";
                                    deleteLineBtn.onclick = function () {
                                        linesData.splice(lIndex, 1);
                                        updateJson();
                                        renderLines();
                                    };

                                    headerDiv.appendChild(titleLabel);
                                    headerDiv.appendChild(deleteLineBtn);
                                    card.appendChild(headerDiv);

                                    const lineInput = document.createElement("input");
                                    lineInput.type = "text";
                                    lineInput.className = "w-full text-xs rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-800 dark:text-gray-200";
                                    lineInput.placeholder = "Nombre de la línea de práctica (ej. Diseño y creación de páginas web)";
                                    lineInput.value = item.line || item.name || "";
                                    lineInput.oninput = function () {
                                        item.line = lineInput.value;
                                        updateJson();
                                    };
                                    card.appendChild(lineInput);

                                    // Activities as discrete individual inputs
                                    const actSection = document.createElement("div");
                                    actSection.className = "mt-2 pt-2 border-t border-gray-200 dark:border-gray-800 space-y-1.5";

                                    const actHeader = document.createElement("div");
                                    actHeader.className = "flex items-center justify-between";

                                    const actTitle = document.createElement("span");
                                    actTitle.className = "text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider";
                                    actTitle.textContent = "Actividades Formativas Específicas:";

                                    const addActBtn = document.createElement("button");
                                    addActBtn.type = "button";
                                    addActBtn.className = "text-[11px] text-indigo-600 dark:text-indigo-400 hover:underline font-semibold";
                                    addActBtn.textContent = "+ Agregar Actividad";

                                    if (!Array.isArray(item.activities)) {
                                        item.activities = item.activities ? [item.activities] : [];
                                    }

                                    addActBtn.onclick = function () {
                                        item.activities.push("");
                                        updateJson();
                                        renderLines();
                                    };

                                    actHeader.appendChild(actTitle);
                                    actHeader.appendChild(addActBtn);
                                    actSection.appendChild(actHeader);

                                    const actList = document.createElement("div");
                                    actList.className = "space-y-1.5";

                                    if (item.activities.length === 0) {
                                        const emptyAct = document.createElement("p");
                                        emptyAct.className = "text-[11px] text-gray-400 italic";
                                        emptyAct.textContent = 'Sin actividades registradas. Clic en "+ Agregar Actividad" para añadir una.';
                                        actList.appendChild(emptyAct);
                                    }

                                    item.activities.forEach((act, actIdx) => {
                                        const actRow = document.createElement("div");
                                        actRow.className = "flex items-center space-x-2";

                                        const numSpan = document.createElement("span");
                                        numSpan.className = "text-[11px] font-semibold text-gray-400 w-4 text-right";
                                        numSpan.textContent = (actIdx + 1) + ".";

                                        const actInput = document.createElement("input");
                                        actInput.type = "text";
                                        actInput.className = "w-full text-xs rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-800 dark:text-gray-200";
                                        actInput.placeholder = "Ej. Diseña páginas web";
                                        actInput.value = act;
                                        actInput.oninput = function () {
                                            item.activities[actIdx] = actInput.value;
                                            updateJson();
                                        };

                                        const delActBtn = document.createElement("button");
                                        delActBtn.type = "button";
                                        delActBtn.className = "text-sm text-red-500 hover:text-red-700 px-1 font-bold";
                                        delActBtn.textContent = "×";
                                        delActBtn.title = "Eliminar actividad";
                                        delActBtn.onclick = function () {
                                            item.activities.splice(actIdx, 1);
                                            updateJson();
                                            renderLines();
                                        };

                                        actRow.appendChild(numSpan);
                                        actRow.appendChild(actInput);
                                        actRow.appendChild(delActBtn);
                                        actList.appendChild(actRow);
                                    });

                                    actSection.appendChild(actList);
                                    card.appendChild(actSection);

                                    container.appendChild(card);
                                });
                            }

                            function updateJson() {
                                hiddenInput.value = JSON.stringify(linesData);
                            }

                            addLineBtn.addEventListener("click", function () {
                                linesData.push({ line: "", activities: [] });
                                updateJson();
                                renderLines();
                            });

                            renderLines();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
