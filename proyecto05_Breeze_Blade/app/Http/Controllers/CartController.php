<?php

namespace App\Http\Controllers;

use App\Models\ProductOffer;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;


class cartController extends Controller
{
    private function getCart(Request $request): array
    {
        return $request->session()->get("cart", [
            "offer_id" => null,
            "items" => []
        ]);
    }

    private function saveCart(Request $request, array $cart): void
    {
        $request->session()->put("cart", $cart);
    }

    public function cartShow(Request $request)
    {
        $carrito = $request->session()->get('cart', []);

        if (empty($carrito)) {
            return view('cart.show', [
                'carrito'               => [],
                'ofertasPorId'          => collect(),
                'productosOfertaPorId'  => collect(),
            ]);
        }

        $idsOfertas = array_keys($carrito);
        $idsProductosOferta = [];

        foreach ($carrito as $idOferta => $articulos) {
            $idsProductosOferta = array_merge($idsProductosOferta, array_keys($articulos));
        }
        $idsProductosOferta = array_unique($idsProductosOferta);

        $ofertasPorId = Offer::whereIn('id', $idsOfertas)
            ->get(['id', 'date_delivery', 'time_delivery'])
            ->keyBy('id');

        $productosOfertaPorId = ProductOffer::with('product')
            ->whereIn('id', $idsProductosOferta)
            ->get()
            ->keyBy('id');

        return view('cart.show', compact('carrito', 'ofertasPorId', 'productosOfertaPorId'));
    }

    public function cartAdd(Request $request, $id)
    {
        $po = ProductOffer::with("offer")->findOrFail($id);

        $cart = $this->getCart($request);

        // No mezclar ofertas: si hay otra oferta en el carrito, lo vaciamos
        if ($cart["offer_id"] !== null && (int)$cart["offer_id"] !== (int)$po->offer_id) {
            $cart = ["offer_id" => null, "items" => []];
            $request->session()->flash("info", "Carrito reiniciado: solo puedes pedir productos de una oferta.");
        }

        $cart["offer_id"] = $po->offer_id;

        if (!isset($cart["items"][$po->id])) {
            $cart["items"][$po->id] = [
                "product_offer_id" => $po->id,
                "qty" => 1,
            ];
        } else {
            $cart["items"][$po->id]["qty"]++;
        }

        $this->saveCart($request, $cart);

        return redirect()->back()->with("success", "Producto añadido al carrito correctamente.");
    }

    public function cartAddOne(Request $request, $id)
    {
        return $this->cartAdd($request, $id);
    }

    public function cartRemoveOne(Request $request, $id)
    {
        $cart = $this->getCart($request);

        if (isset($cart["items"][$id])) {
            $cart["items"][$id]["qty"]--;

            if ($cart["items"][$id]["qty"] <= 0) {
                unset($cart["items"][$id]);
            }
        }

        if (empty($cart["items"])) {
            $cart["offer_id"] = null;
        }

        $this->saveCart($request, $cart);

        return redirect()->route("cartShow");
    }

    public function cartRemove(Request $request, $id)
    {
        $cart = $this->getCart($request);

        if (isset($cart["items"][$id])) {
            unset($cart["items"][$id]);
        }

        if (empty($cart["items"])) {
            $cart["offer_id"] = null;
        }

        $this->saveCart($request, $cart);

        return redirect()->route("cartShow");
    }

    public function cartClear(Request $request)
    {
        $request->session()->forget("cart");
        return redirect()->route("cartShow");
    }

    public function cartOrder(Request $request)
    {
        $cart = $this->getCart($request);

        if (empty($cart["items"])) {
            return redirect()->route("cartShow")->withErrors(["error" => "El carrito está vacío."]);
        }

        $items = $cart["items"];
        $productOfferIds = array_keys($items);

        $productOffers = ProductOffer::with("product")
            ->whereIn("id", $productOfferIds)
            ->get()
            ->keyBy("id");

        $total = 0;
        $rows = [];

        foreach ($items as $poId => $row) {
            if (!isset($productOffers[$poId])) continue;

            $po = $productOffers[$poId];
            $qty = (int)($row["qty"] ?? 1);

            $price = (float)($po->price ?? $po->product->price ?? 0);
            $total += $qty * $price;

            $rows[] = [
                "product_offer_id" => $po->id,
                "quantity" => $qty,
            ];
        }

        if (empty($rows)) {
            return redirect()->route("cartShow")->withErrors(["error" => "El carrito no tiene productos válidos."]);
        }

        $orderId = null;

        DB::transaction(function () use ($total, $rows, &$orderId) {
            $order = Order::create([
                "user_id" => auth()->id(),
                "total" => $total,
            ]);

            $orderId = $order->id;

            $order->products()->createMany($rows);
        });

        $request->session()->forget("cart");

        return redirect()->route("ordersShow")->with("info", "Pedido realizado correctamente (ID: $orderId).");
    }
}
