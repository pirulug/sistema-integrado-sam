<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700/80">
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="studentForm({
                    document_type: '{{ old('document_type', 'DNI') }}',
                    dni: '{{ old('dni', '') }}',
                    student_code: '{{ old('student_code', '') }}',
                    first_name: '{{ old('first_name', '') }}',
                    paternal_last_name: '{{ old('paternal_last_name', '') }}',
                    maternal_last_name: '{{ old('maternal_last_name', '') }}',
                    institutional_email: '{{ old('institutional_email', '') }}',
                    personal_email: '{{ old('personal_email', '') }}',
                    mobile: '{{ old('mobile', '') }}',
                    phone: '{{ old('phone', '') }}',
                    admission_date: '{{ old('admission_date', '') }}',
                    graduation_date: '{{ old('graduation_date', '') }}'
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

                    <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" class="space-y-6" @submit="handleSubmit($event)">
                        @csrf

                        <!-- Photo Upload Section with JS validation -->
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
                                    Fotografía de Perfil <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
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
                            
                            <!-- 1. Tipo de Documento -->
                            <div>
                                <label for="document_type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Tipo de Documento <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <select id="document_type" name="document_type" x-model="form.document_type" @change="handleDocTypeChange()" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" required>
                                    <option value="DNI">DNI (Documento Nacional de Identidad - 8 dígitos)</option>
                                    <option value="CE">CE (Carnet de Extranjería - Alfanumérico)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('document_type')" />
                            </div>

                            <!-- 2. Número de Documento (DNI / CE) con feedback dinámico -->
                            <div>
                                <label for="dni" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    <span x-text="form.document_type === 'DNI' ? 'Número de DNI' : 'Número de Carnet de Extranjería'"></span>
                                    <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="dni" name="dni" type="text" 
                                        x-model="form.dni" 
                                        @input="handleDniInput($event)" 
                                        @blur="touch('dni')"
                                        :placeholder="form.document_type === 'DNI' ? 'Ej. 71234567 (8 dígitos)' : 'Ej. 001234567 (hasta 20 caracteres)'" 
                                        :maxlength="form.document_type === 'DNI' ? 8 : 20"
                                        class="block w-full rounded border text-sm shadow-sm transition"
                                        :class="getInputBorder('dni', isDniValid())"
                                        required autofocus />
                                    
                                    <!-- Dynamic Valid Icon -->
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="isDniValid() && form.dni.length > 0">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>

                                <!-- Dynamic Feedback Message -->
                                <div class="mt-1.5 text-xs font-medium" x-show="touched.dni || form.dni.length > 0">
                                    <template x-if="form.document_type === 'DNI'">
                                        <div>
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
                                    </template>
                                    <template x-if="form.document_type === 'CE'">
                                        <div>
                                            <span x-show="form.dni.length >= 4" class="text-emerald-600 dark:text-emerald-400">
                                                Carnet de Extranjería registrado (<span x-text="form.dni.length"></span> caracteres).
                                            </span>
                                            <span x-show="touched.dni && form.dni.length < 4" class="text-amber-600 dark:text-amber-400">
                                                Ingrese al menos 4 caracteres para el Carnet de Extranjería.
                                            </span>
                                        </div>
                                    </template>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('dni')" />
                            </div>

                            <!-- 3. Código de Estudiante -->
                            <div>
                                <label for="student_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Código de Estudiante <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="student_code" name="student_code" type="text" 
                                        x-model="form.student_code" 
                                        @input="form.student_code = form.student_code.toUpperCase()" 
                                        @blur="touch('student_code')" 
                                        placeholder="Ej. EST2026001" 
                                        maxlength="50"
                                        class="block w-full rounded border text-sm shadow-sm transition font-mono uppercase"
                                        :class="getInputBorder('student_code', form.student_code.trim().length > 0)"
                                        required />
                                    
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="form.student_code.trim().length > 0">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                                <div class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium" x-show="touched.student_code && form.student_code.trim().length === 0">
                                    El código de estudiante es obligatorio.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('student_code')" />
                            </div>

                            <!-- 4. Nombres -->
                            <div>
                                <label for="first_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Nombres <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="first_name" name="first_name" type="text" 
                                        x-model="form.first_name" 
                                        @blur="touch('first_name')" 
                                        placeholder="Ej. Juan Carlos" 
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

                            <!-- 5. Apellido Paterno -->
                            <div>
                                <label for="paternal_last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Apellido Paterno <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="paternal_last_name" name="paternal_last_name" type="text" 
                                        x-model="form.paternal_last_name" 
                                        @blur="touch('paternal_last_name')" 
                                        placeholder="Ej. Perez" 
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

                            <!-- 6. Apellido Materno -->
                            <div>
                                <label for="maternal_last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Apellido Materno <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="maternal_last_name" name="maternal_last_name" type="text" 
                                        x-model="form.maternal_last_name" 
                                        @blur="touch('maternal_last_name')" 
                                        placeholder="Ej. Gomez" 
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

                            <!-- 7. Género (Opcional) -->
                            <div>
                                <label for="gender" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Género <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <select id="gender" name="gender" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">-- Seleccionar Género --</option>
                                    <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>

                            <!-- 8. Programa de Estudio -->
                            <div>
                                <label for="study_program" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Programa de Estudio <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <input id="study_program" name="study_program" type="text" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-300 cursor-not-allowed text-sm shadow-sm font-semibold" value="Diseño y programación web" readonly required />
                                <x-input-error class="mt-2" :messages="$errors->get('study_program')" />
                            </div>

                            <!-- 9. Email Institucional -->
                            <div>
                                <label for="institutional_email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Email Institucional (@sam.edu.pe) <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <div class="relative mt-1">
                                    <input id="institutional_email" name="institutional_email" type="email" 
                                        x-model="form.institutional_email" 
                                        @blur="touch('institutional_email')" 
                                        placeholder="usuario@sam.edu.pe" 
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
                                        Debe terminar obligatoriamente en <strong>@sam.edu.pe</strong> (ej. usuario@sam.edu.pe).
                                    </span>
                                    <span x-show="touched.institutional_email && form.institutional_email.length === 0" class="text-red-600 dark:text-red-400">
                                        El email institucional es obligatorio (@sam.edu.pe).
                                    </span>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('institutional_email')" />
                            </div>

                            <!-- 10. Email Personal (Opcional) -->
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

                            <!-- 11. Celular (Opcional) -->
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

                            <!-- 12. Teléfono Fijo (Opcional) -->
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

                            <!-- 13. Fecha de Ingreso -->
                            <div>
                                <label for="admission_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Fecha de Ingreso <span class="text-red-500 font-bold ml-0.5">*</span>
                                </label>
                                <input id="admission_date" name="admission_date" type="date" 
                                    x-model="form.admission_date" 
                                    @blur="touch('admission_date')" 
                                    class="mt-1 block w-full rounded border text-sm shadow-sm transition"
                                    :class="getInputBorder('admission_date', form.admission_date.length > 0)"
                                    required />
                                <div class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium" x-show="touched.admission_date && form.admission_date.length === 0">
                                    La fecha de ingreso es obligatoria.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('admission_date')" />
                            </div>

                            <!-- 14. Fecha de Egreso (Opcional con validación de coherencia) -->
                            <div>
                                <label for="graduation_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Fecha de Egreso <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <input id="graduation_date" name="graduation_date" type="date" 
                                    x-model="form.graduation_date" 
                                    @blur="touch('graduation_date')" 
                                    class="mt-1 block w-full rounded border text-sm shadow-sm transition"
                                    :class="getInputBorder('graduation_date', isGraduationDateValid())" />
                                
                                <div class="mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400" x-show="form.graduation_date && !isGraduationDateValid()">
                                    Aviso: La fecha de egreso debe ser igual o posterior a la fecha de ingreso.
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('graduation_date')" />
                            </div>

                            <!-- 15. Malla Curricular (Opcional) -->
                            <div>
                                <label for="curriculum_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Malla Curricular <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <select id="curriculum_id" name="curriculum_id" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">-- Asignar después / Sin Malla --</option>
                                    @foreach($curriculums as $curriculum)
                                        <option value="{{ $curriculum->id }}" {{ old('curriculum_id') == $curriculum->id ? 'selected' : '' }}>
                                            {{ $curriculum->name }} ({{ $curriculum->year }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('curriculum_id')" />
                            </div>

                            <!-- 16. Turno (Opcional) -->
                            <div>
                                <label for="shift" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                                    Turno <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Opcional)</span>
                                </label>
                                <select id="shift" name="shift" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    <option value="">-- Seleccionar Turno --</option>
                                    <option value="Diurno (Mañana)" {{ old('shift') == 'Diurno (Mañana)' ? 'selected' : '' }}>Diurno (Mañana)</option>
                                    <option value="Diurno (Tarde)" {{ old('shift') == 'Diurno (Tarde)' ? 'selected' : '' }}>Diurno (Tarde)</option>
                                    <option value="Nocturno (Noche)" {{ old('shift') == 'Nocturno (Noche)' ? 'selected' : '' }}>Nocturno (Noche)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                <span class="text-red-500 font-bold">*</span> Campos requeridos obligatorios.
                            </span>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Cancelar
                                </a>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                    Guardar Estudiante
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function studentForm(initialData) {
            return {
                form: {
                    document_type: initialData.document_type || 'DNI',
                    dni: initialData.dni || '',
                    student_code: initialData.student_code || '',
                    first_name: initialData.first_name || '',
                    paternal_last_name: initialData.paternal_last_name || '',
                    maternal_last_name: initialData.maternal_last_name || '',
                    institutional_email: initialData.institutional_email || '',
                    personal_email: initialData.personal_email || '',
                    mobile: initialData.mobile || '',
                    phone: initialData.phone || '',
                    admission_date: initialData.admission_date || '',
                    graduation_date: initialData.graduation_date || ''
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

                handleDocTypeChange() {
                    if (this.form.document_type === 'DNI') {
                        this.form.dni = this.form.dni.replace(/\D/g, '').slice(0, 8);
                    } else {
                        this.form.dni = this.form.dni.replace(/[^a-zA-Z0-9]/g, '').slice(0, 20);
                    }
                },

                handleDniInput(e) {
                    if (this.form.document_type === 'DNI') {
                        this.form.dni = e.target.value.replace(/\D/g, '').slice(0, 8);
                    } else {
                        this.form.dni = e.target.value.replace(/[^a-zA-Z0-9]/g, '').slice(0, 20);
                    }
                },

                isDniValid() {
                    if (this.form.document_type === 'DNI') {
                        return this.form.dni.length === 8;
                    }
                    return this.form.dni.trim().length >= 4;
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

                isGraduationDateValid() {
                    if (!this.form.graduation_date) return true;
                    if (!this.form.admission_date) return true;
                    return this.form.graduation_date >= this.form.admission_date;
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
                    // Mark all mandatory fields as touched
                    const requiredFields = ['dni', 'student_code', 'first_name', 'paternal_last_name', 'maternal_last_name', 'institutional_email', 'admission_date'];
                    requiredFields.forEach(f => this.touched[f] = true);
                    this.touched['graduation_date'] = true;
                    if (this.form.personal_email) this.touched['personal_email'] = true;

                    const errors = [];

                    if (!this.isDniValid()) {
                        errors.push(this.form.document_type === 'DNI' ? 'El DNI debe contener exactamente 8 dígitos numéricos.' : 'El Carnet de Extranjería debe contener al menos 4 caracteres.');
                    }
                    if (!this.form.student_code.trim()) {
                        errors.push('El Código de Estudiante es obligatorio.');
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
                    if (!this.form.admission_date) {
                        errors.push('La Fecha de Ingreso es obligatoria.');
                    }
                    if (!this.isGraduationDateValid()) {
                        errors.push('La Fecha de Egreso no puede ser anterior a la Fecha de Ingreso.');
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
