<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Login')</title>

    {{-- Bootstrap CSS --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Global CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- CSS khusus halaman auth --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="bg-light">

    {{-- Konten halaman --}}
    @yield('content')

</body>
</html>