<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Profesor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700/80">
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="teacherForm({
                    dni: '{{ old('dni', '') }}',
                    teacher_code: '{{ old('teacher_code', '') }}',
                    first_name: '{{ old('first_name', '') }}',
                    paternal_last_name: '{{ old('paternal_last_name', '') }}',
                    maternal_last_name: '{{ old('maternal_last_name', '') }}',
                    institutional_email: '{{ old('institutional_email', '') }}',
                    personal_email: '{{ old('personal_email', '') }}',
                    mobile: '{{ old('mobile', '') }}',
                    phone: '{{ old('phone', '') }}',
                    hire_date: '{{ old('hire_date', '') }}'
                })">

                    <!-- Global Form Alert Banner -->
                    <div x-show="hasErrors" x-cloak class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-950/50 border-2 border-red-300 dark:border-red-800 text-red-800 dark:text-red-300 flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="flex-1 text-sm">
                            <p class="font-bold">Hay campos obligatorios incompletos o con formato incorrecto:</p>
                            <ul class="list-disc list-inside mt-1 text-xs space-y-0.5" x-html="errorSummaryList"></ul>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('teachers.store') }}" enctype="multipart/form-data" class="space-y-6" @submit="handleSubmit($event)">
                        @csrf

                        <!-- Photo Upload Section with JS preview and validation -->
                        <div class="flex flex-col sm:flex-row items-center gap-6 p-5 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-200 dark:border-gray-700 mb-6">
                            <div class="relative flex-shrink-0">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-24 h-24 rounded-full object-cover border-2 border-indigo-500 shadow-md">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-md border-2 border-dashed border-indigo-300 dark:border-indigo-700">
                                        <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <label for="photo" class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-1">
                                    Fotografía del Profesor <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    Formatos válidos: JPG, PNG o WebP. Tamaño máximo: <strong>2 MB</strong>.
                                </p>
                                <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" 
                                    @change="handlePhotoChange($event)"
                                    class="block w-full text-xs text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/60 dark:file:text-indigo-300 hover:file:bg-indigo-100 cursor-pointer" />
                                
                                <div x-show="photoError" x-cloak class="mt-2 text-xs font-semibold text-red-600 dark:text-red-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span x-text="photoError"></span>
                                </div>
                                <div x-show="photoSuccess && !photoError" x-cloak class="mt-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span x-text="photoSuccess"></span>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- 1. DNI con validación reactiva -->
                            <div>
                                <label for="dni" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Número de DNI <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="dni" name="dni" type="text" 
                                        x-model="form.dni" 
                                        @input="handleDniInput($event)" 
                                        @blur="touch('dni')"
                                        placeholder="Ej. 08123456 (8 dígitos)" 
                                        maxlength="8"
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('dni', isDniValid())"
                                        required autofocus />
                                    
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="isDniValid() && form.dni.length > 0">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>

                                <div class="mt-1.5 text-xs font-medium" x-show="touched.dni || form.dni.length > 0">
                                    <span x-show="form.dni.length === 8" class="text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                        DNI completo y válido (8 dígitos).
                                    </span>
                                    <span x-show="form.dni.length > 0 && form.dni.length < 8" class="text-amber-600 dark:text-amber-400 flex items-center gap-1">
                                        Faltan <span class="font-bold" x-text="8 - form.dni.length"></span> dígitos para completar los 8 requeridos (<span x-text="form.dni.length"></span>/8).
                                    </span>
                                    <span x-show="touched.dni && form.dni.length === 0" class="text-red-600 dark:text-red-400">
                                        El número de DNI es obligatorio.
                                    </span>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                            </div>

                            <!-- 2. Código de Profesor -->
                            <div>
                                <label for="teacher_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Código de Profesor <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="teacher_code" name="teacher_code" type="text" 
                                        x-model="form.teacher_code" 
                                        @input="form.teacher_code = form.teacher_code.toUpperCase()" 
                                        @blur="touch('teacher_code')" 
                                        placeholder="Ej. DOC2026001" 
                                        maxlength="50"
                                        class="block w-full rounded border text-sm shadow-sm transition font-mono uppercase"
                                        :class="getInputBorder('teacher_code', form.teacher_code.trim().length > 0)"
                                        required />
                                    
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="form.teacher_code.trim().length > 0">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium" x-show="touched.teacher_code && form.teacher_code.trim().length === 0">
                                    El código de profesor es obligatorio.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('teacher_code')" />
                            </div>

                            <!-- 3. Nombres -->
                            <div>
                                <label for="first_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Nombres <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="first_name" name="first_name" type="text" 
                                        x-model="form.first_name" 
                                        @blur="touch('first_name')" 
                                        placeholder="Ej. Roberto" 
                                        maxlength="100"
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('first_name', form.first_name.trim().length > 1)"
                                        required />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="form.first_name.trim().length > 1">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium" x-show="touched.first_name && form.first_name.trim().length === 0">
                                    Los nombres son obligatorios.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <!-- 4. Apellido Paterno -->
                            <div>
                                <label for="paternal_last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Apellido Paterno <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="paternal_last_name" name="paternal_last_name" type="text" 
                                        x-model="form.paternal_last_name" 
                                        @blur="touch('paternal_last_name')" 
                                        placeholder="Ej. Mendoza" 
                                        maxlength="100"
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('paternal_last_name', form.paternal_last_name.trim().length > 1)"
                                        required />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="form.paternal_last_name.trim().length > 1">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium" x-show="touched.paternal_last_name && form.paternal_last_name.trim().length === 0">
                                    El apellido paterno es obligatorio.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('paternal_last_name')" />
                            </div>

                            <!-- 5. Apellido Materno -->
                            <div>
                                <label for="maternal_last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Apellido Materno <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="maternal_last_name" name="maternal_last_name" type="text" 
                                        x-model="form.maternal_last_name" 
                                        @blur="touch('maternal_last_name')" 
                                        placeholder="Ej. Salazar" 
                                        maxlength="100"
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('maternal_last_name', form.maternal_last_name.trim().length > 1)"
                                        required />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="form.maternal_last_name.trim().length > 1">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium" x-show="touched.maternal_last_name && form.maternal_last_name.trim().length === 0">
                                    El apellido materno es obligatorio.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('maternal_last_name')" />
                            </div>

                            <!-- 6. Email Institucional -->
                            <div>
                                <label for="institutional_email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Email Institucional (@sam.edu.pe) <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="institutional_email" name="institutional_email" type="email" 
                                        x-model="form.institutional_email" 
                                        @blur="touch('institutional_email')" 
                                        placeholder="profesor@sam.edu.pe" 
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('institutional_email', isInstitutionalEmailValid(form.institutional_email))"
                                        required />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="isInstitutionalEmailValid(form.institutional_email)">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs font-medium" x-show="touched.institutional_email || form.institutional_email.length > 0">
                                    <span x-show="isInstitutionalEmailValid(form.institutional_email)" class="text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                        Correo institucional válido (@sam.edu.pe).
                                    </span>
                                    <span x-show="!isInstitutionalEmailValid(form.institutional_email) && form.institutional_email.length > 0" class="text-amber-600 dark:text-amber-400">
                                        Debe terminar obligatoriamente en <strong>@sam.edu.pe</strong> (ej. profesor@sam.edu.pe).
                                    </span>
                                    <span x-show="touched.institutional_email && form.institutional_email.length === 0" class="text-red-600 dark:text-red-400">
                                        El email institucional es obligatorio (@sam.edu.pe).
                                    </span>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('institutional_email')" />
                            </div>

                            <!-- 7. Email Personal (Opcional) -->
                            <div>
                                <label for="personal_email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Email Personal <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="personal_email" name="personal_email" type="email" 
                                        x-model="form.personal_email" 
                                        @blur="touch('personal_email')" 
                                        placeholder="ejemplo@gmail.com" 
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('personal_email', form.personal_email.length === 0 || isEmailValid(form.personal_email))" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="isEmailValid(form.personal_email)">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs text-amber-600 dark:text-amber-400 font-medium" x-show="form.personal_email.length > 0 && !isEmailValid(form.personal_email)">
                                    Formato de correo no válido.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('personal_email')" />
                            </div>

                            <!-- 8. Celular (Opcional) -->
                            <div>
                                <label for="mobile" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Celular <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="mobile" name="mobile" type="text" 
                                        x-model="form.mobile" 
                                        @input="form.mobile = form.mobile.replace(/\D/g, '').slice(0, 15)" 
                                        placeholder="Ej. 987654321" 
                                        maxlength="15"
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('mobile', form.mobile.length === 0 || form.mobile.length === 9)" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="form.mobile.length === 9">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs text-gray-500 dark:text-gray-400" x-show="form.mobile.length > 0">
                                    <span x-show="form.mobile.length === 9" class="text-emerald-600 dark:text-emerald-400 font-medium">Celular de 9 dígitos válido.</span>
                                    <span x-show="form.mobile.length < 9" class="text-amber-600 dark:text-amber-400 font-medium">Ingresando: <span x-text="form.mobile.length"></span>/9 dígitos.</span>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('mobile')" />
                            </div>

                            <!-- 9. Teléfono Fijo (Opcional) -->
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Teléfono Fijo <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <input id="phone" name="phone" type="text" 
                                    x-model="form.phone" 
                                    @input="form.phone = form.phone.replace(/[^\d\s-]/g, '').slice(0, 15)" 
                                    placeholder="Ej. 01 4567890" 
                                    maxlength="15"
                                    class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-sm shadow-sm" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <!-- 10. Fecha de Contratación -->
                            <div>
                                <label for="hire_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Fecha de Contratación <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <input id="hire_date" name="hire_date" type="date" 
                                    x-model="form.hire_date" 
                                    @blur="touch('hire_date')" 
                                    class="mt-1 block w-full rounded border text-sm shadow-sm transition"
                                    :class="getInputBorder('hire_date', form.hire_date.length > 0)"
                                    required />
                                <div class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium" x-show="touched.hire_date && form.hire_date.length === 0">
                                    La fecha de contratación es obligatoria.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('hire_date')" />
                            </div>
                        </div>

                        <!-- Sección: Habilitar Cuenta de Usuario -->
                        <div class="mt-8 p-5 bg-indigo-50/60 dark:bg-indigo-950/30 rounded-2xl border border-indigo-200 dark:border-indigo-800/60 space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="flex items-start space-x-3 cursor-pointer">
                                    <input type="checkbox" name="create_user_account" value="1" x-model="createUserAccount" class="mt-0.5 w-4 h-4 text-indigo-600 rounded border-gray-300 dark:border-gray-600 focus:ring-indigo-500">
                                    <div>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Crear cuenta de acceso para este profesor</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            El docente podrá ingresar al sistema con su correo institucional (<strong class="text-indigo-600 dark:text-indigo-400 font-mono" x-text="form.institutional_email || 'correo@sam.edu.pe'"></strong>).
                                        </p>
                                    </div>
                                </label>
                            </div>

                            <div x-show="createUserAccount" x-transition class="pt-3 border-t border-indigo-100 dark:border-indigo-800/60 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                        Contraseña Inicial <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input id="password" name="password" type="password" minlength="6" x-model="form.password" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Mínimo 6 caracteres" :required="createUserAccount">
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1">
                                        Confirmar Contraseña <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" minlength="6" x-model="form.password_confirmation" class="w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" placeholder="Repita la contraseña" :required="createUserAccount">
                                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                <span class="text-red-500 font-bold">*</span> Campos requeridos obligatorios.
                            </span>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('teachers.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Cancelar
                                </a>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                    Guardar Profesor
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function teacherForm(initialData) {
            return {
                createUserAccount: {{ old('create_user_account') ? 'true' : 'false' }},
                form: {
                    dni: initialData.dni || '',
                    teacher_code: initialData.teacher_code || '',
                    first_name: initialData.first_name || '',
                    paternal_last_name: initialData.paternal_last_name || '',
                    maternal_last_name: initialData.maternal_last_name || '',
                    institutional_email: initialData.institutional_email || '',
                    personal_email: initialData.personal_email || '',
                    mobile: initialData.mobile || '',
                    phone: initialData.phone || '',
                    hire_date: initialData.hire_date || '',
                    password: '',
                    password_confirmation: ''
                },
                touched: {},
                photoPreview: null,
                photoError: null,
                photoSuccess: null,
                hasErrors: false,
                errorSummaryList: '',

                touch(field) {
                    this.touched[field] = true;
                },

                handleDniInput(e) {
                    this.form.dni = e.target.value.replace(/\D/g, '').slice(0, 8);
                },

                isDniValid() {
                    return this.form.dni.length === 8;
                },

                isInstitutionalEmailValid(email) {
                    if (!email) return false;
                    const re = /^[a-zA-Z0-9._%+-]+@sam\.edu\.pe$/i;
                    return re.test(email.trim());
                },

                isEmailValid(email) {
                    if (!email) return false;
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return re.test(email.trim());
                },

                getInputBorder(field, isValid) {
                    if (this.touched[field]) {
                        if (isValid) {
                            return 'border-emerald-500 focus:border-emerald-500 focus:ring-emerald-500 dark:border-emerald-500 dark:bg-gray-900 text-gray-800 dark:text-gray-100';
                        } else {
                            return 'border-red-500 focus:border-red-500 focus:ring-red-500 dark:border-red-500 dark:bg-gray-900 text-gray-800 dark:text-gray-100 bg-red-50/20';
                        }
                    }
                    return 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500';
                },

                handlePhotoChange(e) {
                    const file = e.target.files[0];
                    this.photoError = null;
                    this.photoSuccess = null;

                    if (!file) {
                        this.photoPreview = null;
                        return;
                    }

                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        this.photoError = 'Formato no admitido. Solo se permiten imágenes JPG, PNG o WebP.';
                        this.photoPreview = null;
                        e.target.value = '';
                        return;
                    }

                    const maxSize = 2 * 1024 * 1024; // 2MB
                    if (file.size > maxSize) {
                        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                        this.photoError = 'El archivo supera el límite de 2 MB (tamaño actual: ' + sizeMb + ' MB). Seleccione una imagen más liviana.';
                        this.photoPreview = null;
                        e.target.value = '';
                        return;
                    }

                    this.photoSuccess = 'Imagen cargada correctamente (' + (file.size / 1024).toFixed(0) + ' KB).';
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.photoPreview = event.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                handleSubmit(e) {
                    const requiredFields = ['dni', 'teacher_code', 'first_name', 'paternal_last_name', 'maternal_last_name', 'institutional_email', 'hire_date'];
                    requiredFields.forEach(f => this.touched[f] = true);
                    if (this.form.personal_email) this.touched['personal_email'] = true;

                    const errors = [];

                    if (!this.isDniValid()) {
                        errors.push('El DNI debe contener exactamente 8 dígitos numéricos.');
                    }
                    if (!this.form.teacher_code.trim()) {
                        errors.push('El Código de Profesor es obligatorio.');
                    }
                    if (!this.form.first_name.trim()) {
                        errors.push('Los Nombres son obligatorios.');
                    }
                    if (!this.form.paternal_last_name.trim()) {
                        errors.push('El Apellido Paterno es obligatorio.');
                    }
                    if (!this.form.maternal_last_name.trim()) {
                        errors.push('El Apellido Materno es obligatorio.');
                    }
                    if (!this.isInstitutionalEmailValid(this.form.institutional_email)) {
                        errors.push('El Email Institucional debe terminar obligatoriamente en @sam.edu.pe.');
                    }
                    if (this.form.personal_email && !this.isEmailValid(this.form.personal_email)) {
                        errors.push('El Email Personal no tiene un formato válido.');
                    }
                    if (this.createUserAccount) {
                        if (!this.form.password || this.form.password.length < 6) {
                            errors.push('La contraseña de acceso debe tener al menos 6 caracteres.');
                        }
                        if (this.form.password !== this.form.password_confirmation) {
                            errors.push('La confirmación de la contraseña no coincide.');
                        }
                    }
                    if (this.photoError) {
                        errors.push(this.photoError);
                    }

                    if (errors.length > 0) {
                        e.preventDefault();
                        this.hasErrors = true;
                        this.errorSummaryList = errors.map(err => '<li>' + err + '</li>').join('');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else {
                        this.hasErrors = false;
                    }
                }
            };
        }
    </script>
</x-app-layout>
