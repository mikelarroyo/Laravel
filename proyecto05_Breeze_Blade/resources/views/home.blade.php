@extends('layouts.plantilla')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Prieto Eats</h2>

    @if($offers->isEmpty())
        <div class="alert alert-info">
            No hay ofertas disponibles ahora mismo.
        </div>
    @else

        {{-- NAV TABS: una tab por oferta --}}
        <ul class="nav nav-tabs" id="offersTabs" role="tablist">
            @foreach($offers as $index => $offer)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                            id="tab-offer-{{ $offer->id }}"
                            data-bs-toggle="tab"
                            data-bs-target="#offer-{{ $offer->id }}"
                            type="button"
                            role="tab"
                            aria-controls="offer-{{ $offer->id }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                        {{ $offer->name }}
                        <small class="d-block text-muted">
                            {{ \Carbon\Carbon::parse($offer->date_delivery)->format('d/m') }}
                            {{ \Carbon\Carbon::parse($offer->time_delivery)->format('H:i') }}
                        </small>
                    </button>
                </li>
            @endforeach
        </ul>

        {{-- TAB CONTENT --}}
        <div class="tab-content border border-top-0 p-3" id="offersTabsContent">
            @foreach($offers as $index => $offer)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                     id="offer-{{ $offer->id }}"
                     role="tabpanel"
                     aria-labelledby="tab-offer-{{ $offer->id }}">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="mb-1">{{ $offer->name }}</h4>
                            <div class="text-muted">
                                Entrega: {{ \Carbon\Carbon::parse($offer->date_delivery)->format('d/m/Y') }}
                                a las {{ \Carbon\Carbon::parse($offer->time_delivery)->format('H:i') }}
                            </div>

                            @if($offer->datetime_limit)
                                <div class="text-danger">
                                    Límite de pedido: {{ \Carbon\Carbon::parse($offer->datetime_limit)->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>

                        <a class="btn btn-outline-primary" href="{{ route('cartShow') }}">
                            Ver carrito
                        </a>
                    </div>

                    @if($offer->productsOffer->isEmpty())
                        <div class="alert alert-warning">
                            Esta oferta no tiene productos asignados.
                        </div>
                    @else
                        <div class="row">
                            @foreach($offer->productsOffer as $po)
                                @php
                                    $p = $po->product;
                                    $precio = $po->price ?? $p->price ?? 0;
                                @endphp

                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        @if(!empty($p->image))
                                            <img src="{{ $p->image }}" class="card-img-top" alt="{{ $p->name }}">
                                        @endif

                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $p->name }}</h5>

                                            @if(!empty($p->description))
                                                <p class="card-text text-muted">{{ $p->description }}</p>
                                            @endif

                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <strong>{{ number_format($precio, 2) }} €</strong>

                                                {{-- AÑADIR AL CARRITO: por productOffer --}}
                                                <form action="{{ route('cartAdd', $po->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm">
                                                        Añadir
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection
