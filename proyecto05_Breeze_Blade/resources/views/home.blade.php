@extends('layouts.plantilla')

@section('content')

<style>
    /* Mantenemos tus estilos CSS intactos */
    .menu-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .menu-card-img {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .menu-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .menu-card:hover .menu-card-img img {
        transform: scale(1.05);
    }

    .menu-card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .menu-card-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .menu-list {
        list-style: none;
        padding: 0;
        margin: 1rem 0;
        flex-grow: 1;
    }

    .menu-list-item {
        display: flex;
        align-items: baseline;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        color: #555;
    }

    .course-badge {
        background-color: #f0fdf4;
        color: #166534;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        margin-right: 0.5rem;
        min-width: 60px;
        text-align: center;
        border: 1px solid #dcfce7;
    }

    .menu-card-footer {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .menu-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: #198754;
    }

    .nav-pills .nav-link {
        color: #555;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 50px;
        background-color: #f8f9fa;
        margin: 0 5px;
        transition: all 0.3s;
    }

    .nav-pills .nav-link.active {
        background-color: #198754;
        color: white;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.3);
    }

    .nav-pills .nav-link:hover:not(.active) {
        background-color: #e9ecef;
    }

    /* Estilo para el mensaje de login */
    .login-notice {
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>

<div class="container py-5">

    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="text-prieto fw-bold display-5">Nuestra Oferta Gastronómica</h2>
            <p class="text-muted">Selecciona una categoría para ver los platos disponibles</p>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-auto">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-menus-tab" data-bs-toggle="pill" data-bs-target="#pills-menus" type="button" role="tab" aria-controls="pills-menus" aria-selected="true">
                        <i class="bi bi-journal-text me-2"></i> Menús del Día
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-carta-tab" data-bs-toggle="pill" data-bs-target="#pills-carta" type="button" role="tab" aria-controls="pills-carta" aria-selected="false">
                        <i class="bi bi-egg-fried me-2"></i> Platos Sueltos (Carta)
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">

        {{-- PESTAÑA 1: MENÚS --}}
        <div class="tab-pane fade show active" id="pills-menus" role="tabpanel" aria-labelledby="pills-menus-tab" tabindex="0">
            <div class="row justify-content-center">
                @forelse($menus as $menu)
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="menu-card w-100">
                        <div class="menu-card-img">
                            <img src="{{ !empty($menu->image) ? asset('storage/'.$menu->image) : 'https://via.placeholder.com/400x250?text=Menu' }}" alt="{{ $menu->name }}">
                        </div>

                        <div class="menu-card-body">
                            <h5 class="menu-card-title">{{ $menu->name }}</h5>

                            @php
                            $desc = $menu->description;
                            $p1 = Str::between($desc, '1º:', '2º:');
                            $p2Part = explode('2º:', $desc)[1] ?? '';
                            $p2 = explode('Postre:', $p2Part)[0] ?? $p2Part;
                            $postre = str_contains($desc, 'Postre:') ? explode('Postre:', $desc)[1] : '';
                            @endphp

                            <ul class="menu-list">
                                <li class="menu-list-item"><span class="course-badge">1º</span> {{ trim(trim($p1), '.') }}</li>
                                <li class="menu-list-item"><span class="course-badge">2º</span> {{ trim(trim($p2), '.') }}</li>
                                <li class="menu-list-item"><span class="course-badge">Postre</span> {{ trim(trim($postre), '.') }}</li>
                            </ul>

                            <div class="menu-card-footer">
                                <span class="menu-price">{{ number_format($menu->price, 2) }}€</span>

                                {{-- CAMBIO AQUÍ --}}
                                @auth
                                <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                        Pedir Menú <i class="bi bi-cart-plus ms-1"></i>
                                    </button>
                                </form>
                                @else
                                <a href="{{ route('login') }}" class="text-prieto text-decoration-none login-notice">
                                    <i class="bi bi-lock-fill"></i> Logueate para pedir
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">No hay menús configurados para hoy.</h4>
                </div>
                @endforelse
            </div>
        </div>

        {{-- PESTAÑA 2: CARTA --}}
        <div class="tab-pane fade" id="pills-carta" role="tabpanel" aria-labelledby="pills-carta-tab" tabindex="0">
            <div class="row justify-content-center">
                @forelse($platos as $plato)
                <div class="col-md-3 mb-4 d-flex align-items-stretch">
                    <div class="menu-card w-100">
                        <div class="menu-card-img" style="height: 180px;">
                            <img src="{{ !empty($plato->image) ? asset('storage/'.$plato->image) : 'https://via.placeholder.com/400x250?text=Plato' }}" alt="{{ $plato->name }}">
                        </div>

                        <div class="menu-card-body">
                            <h5 class="menu-card-title fs-5">{{ $plato->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($plato->description, 70) }}</p>

                            <div class="menu-card-footer pt-2">
                                <span class="menu-price fs-4">{{ number_format($plato->price, 2) }}€</span>

                                {{-- CAMBIO AQUÍ --}}
                                @auth
                                <form action="{{ route('cart.add', $plato->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success rounded-pill btn-sm px-3 fw-bold">
                                        Añadir <i class="bi bi-plus-lg"></i>
                                    </button>
                                </form>
                                @else
                                <a href="{{ route('login') }}" class="text-prieto text-decoration-none login-notice small">
                                    <i class="bi bi-lock-fill"></i> Logueate
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">La carta está vacía en este momento.</h4>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
