<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Dashboard') - Wizzmie Inventory
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-[#f7f7f9] text-slate-800">

    <div class="min-h-screen">

        @include('layouts.navigation')

        <main class="lg:ml-64 pt-16">

            <div class="px-4 py-6 sm:px-6 lg:px-8">

                @yield('content')

            </div>

        </main>

    </div>

    @stack('scripts')

</body>

</html>
