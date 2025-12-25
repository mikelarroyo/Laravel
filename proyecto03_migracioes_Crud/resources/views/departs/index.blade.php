@extends('layouts.layout')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Departamentos</h1>

        <a href="{{ route('departs.create') }}" class="btn btn-primary">
            ➕ Nuevo departamento
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Dept nº</th>
                    <th>Nombre</th>
                    <th>Localización</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($departs as $d)
                <tr>
                    <td>{{ $d->depart_no }}</td>
                    <td class="fw-semibold">{{ $d->dnombre }}</td>
                    <td>{{ $d->loc }}</td>

                    <td class="text-center">
                        <a href="{{ route('departs.edit', $d->depart_no) }}"
                           class="btn btn-sm btn-warning me-1">
                            ✏️
                        </a>

                        <form action="{{ route('departs.destroy', $d->depart_no) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Seguro que deseas borrar este departamento?')">
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
