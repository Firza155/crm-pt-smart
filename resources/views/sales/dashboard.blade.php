<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Sales | CRM PT Smart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Dashboard Sales</h4>
            <p>Selamat datang, {{ auth()->user()->name }}</p>

            <hr>

            <ul>
                <li>Kelola Lead</li>
                <li>Mengajukan Project</li>
                <li>Melihat Status Project</li>
            </ul>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger mt-3">Logout</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
