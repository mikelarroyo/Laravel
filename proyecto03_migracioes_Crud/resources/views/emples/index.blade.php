@extends('layouts.layout')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Empleados</h1>

        <a href="{{ route('emples.create') }}" class="btn btn-primary">
            ➕ Nuevo empleado
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Emp nº</th>
                    <th>Apellido</th>
                    <th>Foto</th>
                    <th>Oficio</th>
                    <th>Director</th>
                    <th>Departamento</th>
                    <th>Salario</th>
                    <th>Comisión</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($emples as $e)
                <tr>
                    <td>{{ $e->emple_no }}</td>
                    <td class="fw-semibold">{{ $e->apellido }}</td>

                    {{-- FOTO --}}
                    <td>
                        @if (!empty($e->foto))
                            <img src="{{ asset('storage/'.$e->foto) }}"
                                 class="rounded-circle border"
                                 width="50"
                                 height="50"
                                 style="object-fit: cover">
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>{{ $e->oficio }}</td>
                    <td>{{ $e->director->apellido ?? '—' }}</td>
                    <td>{{ $e->depart->dnombre ?? '—' }}</td>
                    <td>{{ number_format($e->salario, 2) }} €</td>
                    <td>{{ $e->comision ?? '—' }}</td>

                    <td class="text-center">
                        <a href="{{ route('emples.edit', $e->emple_no) }}"
                           class="btn btn-sm btn-warning me-1">
                            ✏️
                        </a>

                        <form action="{{ route('emples.destroy', $e->emple_no) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Seguro que deseas borrar este empleado?')">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

</div>
@endsection
