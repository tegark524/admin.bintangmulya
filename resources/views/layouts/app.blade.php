<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bintang Mulya') }}</title>
    <link rel="icon" href="{{ asset('logo-icon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('logo-icon.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('logo-icon.png') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    {{-- Vite CSS (jika Anda masih menggunakannya) --}}
    @vite(['resources/css/app.css'])

    {{-- Style tambahan per halaman (jika ada) --}}
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pt-3">
                    {{-- Perintah @yield('content') harus ada DI DALAM content-wrapper --}}
                    @yield('content')
                </div>
            </section>
        </div>
        @include('layouts.footer')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    {{-- Vite JS (jika Anda masih menggunakannya) --}}
    @vite(['resources/js/app.js'])

    {{-- Script tambahan per halaman (misal: untuk AJAX) --}}
    @stack('scripts')

</body>

</html>
