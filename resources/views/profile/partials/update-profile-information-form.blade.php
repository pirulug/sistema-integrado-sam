<section>
    <header class="pb-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Información del Perfil</span>
        </h3>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Consulte sus datos registrados y actualice su nombre visible en la plataforma.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nombre Completo -->
            <div class="md:col-span-2">
                <label for="name" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                    Nombre Completo <span class="text-red-500 font-bold">*</span>
                </label>
                <input id="name" name="name" type="text" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- DNI (Solo lectura) -->
            <div>
                <label for="dni" class="block font-medium text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                    Documento de Identidad (DNI)
                </label>
                <input id="dni" type="text" value="{{ $user->dni ?? 'No registrado' }}" class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 rounded-xl font-mono cursor-not-allowed" readonly disabled />
            </div>

            <!-- Rol en el Sistema (Solo lectura) -->
            <div>
                <label for="role" class="block font-medium text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                    Rol en el Sistema
                </label>
                <input id="role" type="text" value="{{ $user->role === 'admin' ? 'Administrador' : ($user->role === 'teacher' ? 'Profesor / Docente' : ucfirst($user->role)) }}" class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 rounded-xl font-medium cursor-not-allowed" readonly disabled />
            </div>

            <!-- Correo Electrónico (Solo Lectura con Alerta) -->
            <div class="md:col-span-2">
                <label for="email" class="block font-medium text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                    Correo Electrónico de Acceso <span class="text-xs text-gray-400 font-normal">(Institucional / Fijo)</span>
                </label>
                <input id="email" type="email" class="w-full text-sm border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 rounded-xl font-mono cursor-not-allowed" value="{{ $user->email }}" readonly disabled />
                <div class="mt-2 p-3 bg-amber-50 dark:bg-amber-950/30 rounded-xl border border-amber-200 dark:border-amber-900/60 text-xs text-amber-800 dark:text-amber-300 flex items-start space-x-2">
                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        Por políticas institucionales de seguridad, el correo electrónico está asignado de forma fija y no puede ser modificado directamente. Si requiere un cambio de correo, comuníquese con el administrador del sistema.
                    </span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                Guardar Cambios
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-xs text-emerald-600 dark:text-emerald-400 font-bold flex items-center"
                >
                    <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Guardado exitosamente.
                </p>
            @endif
        </div>
    </form>
</section>
