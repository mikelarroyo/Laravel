@extends('layouts.layout')

@section('content')
<h1>Editar empleado</h1>

<form action="{{ route('emples.update', $emple->emple_no) }}" method="POST">
    @csrf
    @method('PUT')

    <p><strong>Nº:</strong> {{ $emple->emple_no }}</p>

    <input type="text" name="apellido" value="{{ $emple->apellido }}" required><br><br>
    <input type="text" name="oficio" value="{{ $emple->oficio }}" required><br><br>

    <label>Director</label><br>
    <select name="dir">
        <option value="">-- Sin director --</option>
        @foreach ($directores as $d)
            <option value="{{ $d->emple_no }}"
                @selected($emple->dir == $d->emple_no)>
                {{ $d->apellido }}
            </option>
        @endforeach
    </select><br><br>

    <input type="date" name="fecha_alt" value="{{ $emple->fecha_alt }}" required><br><br>
    <input type="number" step="0.01" name="salario" value="{{ $emple->salario }}" required><br><br>
    <input type="number" step="0.01" name="comision" value="{{ $emple->comision }}"><br><br>

    <select name="depart_no">
        @foreach ($departs as $dep)
            <option value="{{ $dep->depart_no }}"
                @selected($emple->depart_no == $dep->depart_no)>
                {{ $dep->dnombre }}
            </option>
        @endforeach
    </select><br><br>

    <button>Actualizar</button>
</form>
@endsection
