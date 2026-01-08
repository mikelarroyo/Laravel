@extends('layouts.plantilla')

@section('content')
<div class="container py-5">
    <div class="row align-items-center py-5">
        <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
            <h1 class="display-3 fw-bold text-dark mb-3">
                Gestión de Comedor <br>
                <span class="text-prieto">Prieto Eats</span>
            </h1>
            <p class="lead text-secondary mb-4">
                La solución integral para administrar menús, empleados y departamentos.
                Optimiza los recursos de tu empresa con nuestra plataforma.
            </p>

            <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-prieto btn-lg px-4 shadow rounded-pill">
                        Ir al Panel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-prieto btn-lg px-4 shadow rounded-pill">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-prieto btn-lg px-4 rounded-pill">
                        Crear Cuenta
                    </a>
                @endauth
            </div>
        </div>

        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                 alt="Comida saludable"
                 class="img-fluid rounded-4 shadow-lg">
        </div>
    </div>
</div>

<div class="bg-white py-5">
    <div class="container">
        <div class="row text-center g-4">

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all p-4">
                    <div class="mb-3">
                        <i class="bi bi-book-half display-4 text-prieto"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Gestión de Menús</h3>
                    <p class="text-muted mb-0">
                        Crea, edita y organiza los menús diarios. Asigna platos específicos por día y categoría de forma sencilla.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all p-4">
                    <div class="mb-3">
                        <i class="bi bi-people-fill display-4 text-prieto"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Control de Empleados</h3>
                    <p class="text-muted mb-0">
                        Administra la base de datos de tu personal. Gestiona departamentos, cargos y permisos de acceso.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all p-4">
                    <div class="mb-3">
                        <i class="bi bi-bar-chart-line-fill display-4 text-prieto"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Reportes y Estadísticas</h3>
                    <p class="text-muted mb-0">
                        Visualiza el consumo del comedor y genera informes detallados para optimizar costes y recursos.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: 0.3s ease;
    }
</style>
@endsection
