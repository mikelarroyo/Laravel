<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Prieto Eats Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Estilos CSS (puedes poner esto en tu archivo .css) */
        body {
            margin: 0;
            font-family: sans-serif;
        }

        .navbar {
            background-color: #28a745;
            /* El color verde de tu barra */
            display: flex;
            justify-content: space-between;
            /* Separa el logo de las opciones */
            align-items: center;
            padding: 15px 40px;
            color: white;
        }

        .logo-container {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-img {
            height: 40px;
            /* Ajusta esto al tamaño de tu logo real */
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            /* Espacio entre cada opción */
        }

        .nav-item {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: opacity 0.3s;
        }

        .nav-item:hover {
            opacity: 0.8;
            /* Un pequeño efecto al pasar el mouse */
        }

        /* Espacio entre el icono y el texto */
        .nav-item i {
            margin-right: 8px;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo-container">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Prieto Eats" class="logo-img">
            <span>Prieto Eats</span>
        </div>

        <div class="nav-links">
            <a href="#" class="nav-item">
                <i class="fas fa-envelope"></i> Contacto
            </a>

            @auth
            {{-- SE MUESTRA CUANDO ESTÁS LOGUEADO --}}
            <span class="nav-item">
                <i class="fas fa-user"></i> {{ Auth::user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <a href="{{ route('logout') }}" class="nav-item"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
            @else
            {{-- SE MUESTRA CUANDO ERES INVITADO (GUEST) --}}
            <a href="{{ route('login') }}" class="nav-item">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>

            <a href="{{ route('register') }}" class="nav-item">
                <i class="fas fa-user-plus"></i> Registrarse
            </a>
            @endauth
        </div>
    </nav>
</body>

</html>
