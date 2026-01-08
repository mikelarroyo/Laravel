<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prieto Eats - Gestión de Menús</title>
</head>
<body class="min-h-screen flex flex-col bg-gray-50 font-sans">

    @include('layouts.navbar')

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    @include('layouts.footer')

</body>
</html>
