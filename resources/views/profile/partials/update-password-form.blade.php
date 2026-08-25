<section>
    <header class="pb-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span>Seguridad y Contraseña</span>
        </h3>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Asegúrese de que su cuenta utilice una contraseña segura y difícil de adivinar para proteger su acceso.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                Contraseña Actual <span class="text-red-500 font-bold">*</span>
            </label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm" autocomplete="current-password" placeholder="Ingrese su clave actual" required />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="update_password_password" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                    Nueva Contraseña <span class="text-red-500 font-bold">*</span>
                </label>
                <input id="update_password_password" name="password" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm" autocomplete="new-password" placeholder="Mínimo 6 caracteres" required />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                    Confirmar Nueva Contraseña <span class="text-red-500 font-bold">*</span>
                </label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" minlength="6" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100 shadow-sm" autocomplete="new-password" placeholder="Repita la nueva contraseña" required />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                Actualizar Contraseña
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-xs text-emerald-600 dark:text-emerald-400 font-bold flex items-center"
                >
                    <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Contraseña actualizada exitosamente.
                </p>
            @endif
        </div>
    </form>
</section>
