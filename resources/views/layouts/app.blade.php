<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM PT Smart')</title>

    {{-- Bootstrap CSS --}}
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >

    {{-- CSS global --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- CSS halaman spesifik --}}
    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    @include('partials.navbar')

    <main class="container mt-4">
        {{-- Flash message --}}
        @include('partials.flash')

        {{-- Konten utama --}}
        @yield('content')
    </main>
    {{-- Script halaman spesifik --}}
    @stack('scripts')
</body>
</html>
