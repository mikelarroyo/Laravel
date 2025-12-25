<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aplicación')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Mi App</a>

        <div class="navbar-nav">
            <a class="nav-link" href="{{ route('departs.index') }}">Departamentos</a>
            <a class="nav-link" href="{{ route('emples.index') }}">Empleados</a>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

{{-- Bootstrap JS (opcional, pero recomendado) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
