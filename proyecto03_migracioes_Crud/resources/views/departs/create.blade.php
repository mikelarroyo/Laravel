@extends('layouts.layout')

@section('content')
<h1>Crear departamento</h1>

<form action="{{ route('departs.store') }}" method="POST">
    @csrf

    <label>Departamento Nº</label><br>
    <input type="number" name="depart_no" ><br><br>

    <label>Nombre</label><br>
    <input type="text" name="dnombre" ><br><br>

    <label>Localización</label><br>
    <input type="text" name="loc"><br><br>

    <button>Guardar</button>
</form>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @if (session('success'))
        <div>
            <p style="color:green">{{ session('success') }}</p>
        </div>
    @endif

@endsection
