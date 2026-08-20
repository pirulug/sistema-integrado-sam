<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">
        <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Dark Mode Detection -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- Session Feedback Toasts -->
        @if (session("success"))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    if (window.showToast) {
                        window.showToast("{{ session('success') }}", "success");
                    }
                });
            </script>
        @endif
        @if (session("error"))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    if (window.showToast) {
                        window.showToast("{{ session('error') }}", "error");
                    }
                });
            </script>
        @endif
        @if (session("warning"))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    if (window.showToast) {
                        window.showToast("{{ session('warning') }}", "warning");
                    }
                });
            </script>
        @endif
        @if (session("info"))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    if (window.showToast) {
                        window.showToast("{{ session('info') }}", "info");
                    }
                });
            </script>
        @endif
        @if ($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    if (window.showToast) {
                        window.showToast("{{ $errors->first() }}", "error");
                    }
                });
            </script>
        @endif
    </body>
</html>
