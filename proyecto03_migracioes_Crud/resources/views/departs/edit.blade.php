@extends('layouts.layout')

@section('content')
<h1>Editar departamento</h1>

<form action="{{ route('departs.update', $depart->depart_no) }}" method="POST">
    @csrf
    @method('PUT')

    <p><strong>Nº:</strong> {{ $depart->depart_no }}</p>

    <input type="text" name="dnombre" value="{{ $depart->dnombre }}" required><br><br>
    <input type="text" name="loc" value="{{ $depart->loc }}" required><br><br>

    <button>Actualizar</button>
</form>
@endsection
