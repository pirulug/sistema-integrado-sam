<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2.5">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Crear Nuevo Usuario</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Cree una cuenta de Administrador o asigne credenciales de acceso a un Profesor con su correo institucional.
                </p>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-3.5 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl text-xs font-bold shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Volver a la Lista</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8" x-data="createUserForm({
        initialRole: '{{ old('role', request('role', 'admin')) }}',
        teachersData: {{ Js::from($unassignedTeachers) }},
        preselectedTeacherId: '{{ old('teacher_id', $selectedTeacher ? $selectedTeacher->id : '') }}'
    })">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6 md:p-8">

                <!-- Role Selection Header -->
                <div class="mb-8">
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                        Tipo de Usuario a Crear <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Option Admin -->
                        <div @click="setRole('admin')" class="p-4 rounded-2xl border-2 cursor-pointer transition flex items-start space-x-3.5" :class="role === 'admin' ? 'border-purple-600 bg-purple-50/50 dark:bg-purple-950/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'">
                            <input type="radio" name="role_selector" value="admin" :checked="role === 'admin'" class="mt-1 text-purple-600 focus:ring-purple-500">
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                                    <span>Administrador</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">Total</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Acceso irrestricto a mallas curriculares, cursos, docentes, estudiantes, EFSRT y configuración.
                                </p>
                            </div>
                        </div>

                        <!-- Option Teacher -->
                        <div @click="setRole('teacher')" class="p-4 rounded-2xl border-2 cursor-pointer transition flex items-start space-x-3.5" :class="role === 'teacher' ? 'border-blue-600 bg-blue-50/50 dark:bg-blue-950/20 shadow-sm' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'">
                            <input type="radio" name="role_selector" value="teacher" :checked="role === 'teacher'" class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                                    <span>Profesor / Docente</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300">Desde tabla Teacher</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Los datos (Nombre, DNI, Email institucional) se importan automáticamente de la tabla de docentes y no son editables.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" @submit="handleSubmit($event)" class="space-y-6">
                    @csrf
                    <input type="hidden" name="role" :value="role">

                    <!-- Section: Asignar a Docente Existente (Solo si role == 'teacher') -->
                    <div x-show="role === 'teacher'" class="p-5 bg-blue-50/70 dark:bg-blue-950/30 rounded-2xl border border-blue-200 dark:border-blue-800/60 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-blue-900 dark:text-blue-200 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Seleccionar Profesor Registrado</span>
                            </h3>
                            <span class="text-xs text-blue-700 dark:text-blue-300 font-medium">
                                {{ $unassignedTeachers->count() }} docentes sin usuario
                            </span>
                        </div>

                        <div>
                            <label for="teacher_id" class="block font-medium text-xs text-blue-900 dark:text-blue-200 uppercase tracking-wider mb-1">
                                Docente de la Base de Datos <span class="text-red-500">*</span>
                            </label>
                            <select id="teacher_id" name="teacher_id" x-model="selectedTeacherId" @change="onTeacherSelected()" class="w-full text-sm border-blue-300 dark:border-blue-700 dark:bg-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-gray-100">
                                <option value="">-- Seleccione un profesor de la lista --</option>
                                <template x-for="t in teachersData" :key="t.id">
                                    <option :value="t.id" x-text="t.paternal_last_name + ' ' + t.maternal_last_name + ', ' + t.first_name + ' (DNI: ' + t.dni + ' - ' + t.institutional_email + ')'"></option>
                                </template>
                            </select>
                            <div class="mt-1 text-xs text-blue-700 dark:text-blue-300 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Al elegir el docente, sus datos se traerán automáticamente y quedarán bloqueados para edición.</span>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('teacher_id')" />
                        </div>
                    </div>

                    <!-- Datos del Usuario -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Nombre Completo -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="name" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <span x-show="role === 'teacher'" class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold">
                                    (Tabla Teacher - Bloqueado)
                                </span>
                            </div>
                            <template x-if="role === 'admin'">
                                <input id="name" name="name" type="text" x-model="form.name" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Ej. Maria Elena Ramirez Soto" required>
                            </template>
                            <template x-if="role === 'teacher'">
                                <input type="text" :value="form.name || 'Seleccione un docente arriba...'" readonly disabled class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-xl cursor-not-allowed font-medium">
                            </template>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- DNI -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="dni" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    DNI <span class="text-xs text-gray-400 font-normal">(8 dígitos)</span>
                                </label>
                                <span x-show="role === 'teacher'" class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold">
                                    (Tabla Teacher - Bloqueado)
                                </span>
                            </div>
                            <template x-if="role === 'admin'">
                                <input id="dni" name="dni" type="text" x-model="form.dni" maxlength="20" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 font-mono" placeholder="87654321">
                            </template>
                            <template x-if="role === 'teacher'">
                                <input type="text" :value="form.dni || 'Seleccione un docente arriba...'" readonly disabled class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-xl font-mono cursor-not-allowed">
                            </template>
                            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                        </div>

                        <!-- Correo Electrónico de Acceso -->
                        <div class="md:col-span-2">
                            <div class="flex items-center justify-between mb-1">
                                <label for="email" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    Correo Electrónico de Acceso <span class="text-red-500">*</span>
                                </label>
                                <span x-show="role === 'teacher'" class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold">
                                    (Institucional @sam.edu.pe - Bloqueado)
                                </span>
                            </div>
                            <template x-if="role === 'admin'">
                                <input id="email" name="email" type="email" x-model="form.email" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="admin@ejemplo.com" required>
                            </template>
                            <template x-if="role === 'teacher'">
                                <div>
                                    <input type="email" :value="form.email || 'Seleccione un docente arriba...'" readonly disabled class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-xl font-mono cursor-not-allowed">
                                    <p class="mt-1.5 text-xs text-blue-600 dark:text-blue-400 font-medium">
                                        El profesor iniciará sesión exclusivamente con este correo institucional.
                                    </p>
                                </div>
                            </template>
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Contraseña Inicial -->
                        <div>
                            <label for="password" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                Contraseña Inicial <span class="text-red-500">*</span>
                            </label>
                            <input id="password" name="password" type="password" x-model="form.password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Mínimo 6 caracteres" required>
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div>
                            <label for="password_confirmation" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                Confirmar Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" x-model="form.password_confirmation" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Repita la contraseña" required>
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end space-x-3">
                        <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-bold transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                            Crear Usuario
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function createUserForm(config) {
            return {
                role: config.initialRole,
                teachersData: config.teachersData || [],
                selectedTeacherId: config.preselectedTeacherId || '',
                form: {
                    name: '{{ old('name') }}',
                    dni: '{{ old('dni') }}',
                    email: '{{ old('email') }}',
                    password: '',
                    password_confirmation: ''
                },

                init() {
                    if (this.selectedTeacherId) {
                        this.onTeacherSelected();
                    }
                },

                setRole(newRole) {
                    this.role = newRole;
                    if (newRole === 'admin') {
                        this.selectedTeacherId = '';
                        this.form.name = '{{ old('name') }}';
                        this.form.dni = '{{ old('dni') }}';
                        this.form.email = '{{ old('email') }}';
                    } else if (newRole === 'teacher') {
                        if (this.selectedTeacherId) {
                            this.onTeacherSelected();
                        } else {
                            this.form.name = '';
                            this.form.dni = '';
                            this.form.email = '';
                        }
                    }
                },

                onTeacherSelected() {
                    if (!this.selectedTeacherId) {
                        this.form.name = '';
                        this.form.dni = '';
                        this.form.email = '';
                        return;
                    }
                    const teacher = this.teachersData.find(t => t.id == this.selectedTeacherId);
                    if (teacher) {
                        this.form.name = `${teacher.paternal_last_name} ${teacher.maternal_last_name}, ${teacher.first_name}`;
                        this.form.dni = teacher.dni || '';
                        this.form.email = teacher.institutional_email || '';
                    }
                },

                handleSubmit(e) {
                    if (this.role === 'teacher' && !this.selectedTeacherId) {
                        alert('Debe seleccionar obligatoriamente un profesor de la lista.');
                        e.preventDefault();
                        return;
                    }

                    if (this.form.password !== this.form.password_confirmation) {
                        alert('La contraseña y su confirmación no coinciden.');
                        e.preventDefault();
                        return;
                    }
                }
            }
        }
    </script>
</x-app-layout>
