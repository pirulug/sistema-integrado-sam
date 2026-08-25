<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2.5">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Mi Perfil de Usuario</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Gestione su información personal y la seguridad de acceso a su cuenta en el sistema.
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3.5 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl text-xs font-bold shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Volver al Panel</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alerts -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-800 dark:text-emerald-300 text-sm font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Summary Header Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    @if ($user->photo_url)
                        <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500 shadow-md flex-shrink-0">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xl shadow-md flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <div class="text-sm font-mono text-gray-500 dark:text-gray-400 mt-0.5">{{ $user->email }}</div>
                    </div>
                </div>
                <div>
                    @if ($user->role === 'admin')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                            Rol: Administrador
                        </span>
                    @elseif ($user->role === 'teacher')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                            Rol: Profesor / Docente
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            Rol: {{ ucfirst($user->role) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Form: Información Personal -->
            <div class="p-6 md:p-8 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Form: Seguridad y Contraseña -->
            <div class="p-6 md:p-8 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700">
                @include('profile.partials.update-password-form')
            </div>

        </div>
    </div>
</x-app-layout>
