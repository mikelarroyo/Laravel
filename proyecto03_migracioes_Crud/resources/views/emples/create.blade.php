@extends('layouts.layout')

@section('content')
<h1>Crear empleado</h1>

<form action="{{ route('emples.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="number" name="emple_no" placeholder="Empleado Nº" required><br><br>
    <input type="text" name="apellido" placeholder="Apellido" required><br><br>
    <input type="text" name="oficio" placeholder="Oficio" required><br><br>

    <label>Director</label><br>
    <select name="dir">
        <option value="">-- Sin director --</option>
        @foreach ($directores as $d)
        <option value="{{ $d->emple_no }}">{{ $d->apellido }}</option>
        @endforeach
    </select><br><br>

    <label>Fecha alta</label><br>
    <input type="date" name="fecha_alt" required><br><br>
    <input type="number" step="0.01" name="salario" placeholder="Salario" required><br><br>
    <input type="number" step="0.01" name="comision" placeholder="Comisión"><br><br>

    <label>Departamento</label><br>
    <select name="depart_no" required>
        @foreach ($departs as $dep)
        <option value="{{ $dep->depart_no }}">{{ $dep->dnombre }}</option>
        @endforeach
    </select><br><br>

    <label>Foto del empleado</label><br>
    <input type="file" name="foto"><br><br>

    <button>Guardar</button>
</form>
@endsection
