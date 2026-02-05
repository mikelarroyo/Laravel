@extends('layouts.plantilla')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Carrito</h2>

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
    @endif

    @if(empty($lineas))
        <div class="alert alert-secondary">Tu carrito está vacío.</div>
        <a href="{{ route('home_prieto') }}" class="btn btn-primary">Volver a ofertas</a>
    @else

        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th style="width:170px;">Cantidad</th>
                    <th>Subtotal</th>
                    <th style="width:120px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($lineas as $l)
                    @php
                        $po = $l["po"];
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $po->product->name }}</strong>
                            <div class="text-muted small">
                                Oferta #{{ $po->offer_id }}
                            </div>
                        </td>
                        <td>{{ number_format($l["precio"], 2) }} €</td>
                        <td>
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('cartRemoveOne', $po->id) }}">
                                    @csrf
                                    <button class="btn btn-outline-secondary btn-sm">-</button>
                                </form>

                                <span class="pt-1">{{ $l["qty"] }}</span>

                                <form method="POST" action="{{ route('cartAddOne', $po->id) }}">
                                    @csrf
                                    <button class="btn btn-outline-secondary btn-sm">+</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ number_format($l["subtotal"], 2) }} €</td>
                        <td>
                            <form method="POST" action="{{ route('cartRemove', $po->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Quitar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <form method="POST" action="{{ route('cartClear') }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger">Vaciar carrito</button>
            </form>

            <h4 class="m-0">Total: {{ number_format($total, 2) }} €</h4>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            <form method="POST" action="{{ route('cartOrder') }}">
                @csrf
                <button class="btn btn-success">Realizar pedido</button>
            </form>
        </div>

    @endif

</div>
@endsection
