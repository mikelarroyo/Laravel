<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Order;
use App\Models\ProductOffer;
use App\Models\ProductOrder;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    public function cartShow()
    {
        $carrito = session("carrito", []);

        $offerIds = array_keys($carrito);

        $productOfferIds = [];
        foreach ($carrito as $offerId => $items) {
            $productOfferIds = array_merge($productOfferIds, array_keys($items));
        }
        $productOfferIds = array_unique($productOfferIds);

        $offersById = Offer::whereIn("id", $offerIds)->get()->keyBy("id");

        $productsOffersById = ProductOffer::with("product")
            ->whereIn("id", $productOfferIds)
            ->get()
            ->keyBy("id");

        // OJO: esta vista aún tienes que crearla en pasos siguientes,
        // pero así ya dejamos el controlador coherente.
        return view("carrito", compact("carrito", "offersById", "productsOffersById"));
    }

    public function cartAdd($productOfferId)
    {
        $carrito = session()->get("carrito", []);
        $productOffer = ProductOffer::findOrFail($productOfferId);

        $offerId = $productOffer->offer_id;

        if (!isset($carrito[$offerId])) {
            $carrito[$offerId] = [];
        }

        if (!isset($carrito[$offerId][$productOfferId])) {
            $carrito[$offerId][$productOfferId] = 0;
        }

        $carrito[$offerId][$productOfferId]++;

        session()->put("carrito", $carrito);

        return redirect()->route("cartShow");
    }

    // Aquí “remove” elimina la OFERTA del carrito (por el id que llega en la ruta)
    public function cartRemove($offerId)
    {
        $carrito = session("carrito", []);

        if (isset($carrito[$offerId])) {
            unset($carrito[$offerId]);
        }

        session()->put("carrito", $carrito);

        return redirect()->route("cartShow");
    }

    public function cartClear()
    {
        session()->forget("carrito");
        return redirect()->route("home_prieto");
    }

    // De momento los dejo coherentes con la estructura nueva:
    // Si luego quieres “+1 / -1” por línea, en el Paso 5 lo dejamos perfecto.
    public function cartAddOne($productOfferId)
    {
        $carrito = session("carrito", []);
        $productOffer = ProductOffer::findOrFail($productOfferId);
        $offerId = $productOffer->offer_id;

        if (isset($carrito[$offerId][$productOfferId])) {
            $carrito[$offerId][$productOfferId]++;
        }

        session()->put("carrito", $carrito);
        return redirect()->route("cartShow");
    }

    public function cartRemoveOne($productOfferId)
    {
        $carrito = session("carrito", []);
        $productOffer = ProductOffer::findOrFail($productOfferId);
        $offerId = $productOffer->offer_id;

        if (isset($carrito[$offerId][$productOfferId])) {
            $carrito[$offerId][$productOfferId]--;
            if ($carrito[$offerId][$productOfferId] <= 0) {
                unset($carrito[$offerId][$productOfferId]);
            }
            if (empty($carrito[$offerId])) {
                unset($carrito[$offerId]);
            }
        }

        session()->put("carrito", $carrito);
        return redirect()->route("cartShow");
    }

    public function cartOrder()
    {
        $carrito = session("carrito", []);

        if (empty($carrito)) {
            return redirect()->route("cartShow");
        }

        // aplanamos productOfferId => qty
        $lineas = [];
        foreach ($carrito as $offerId => $items) {
            foreach ($items as $productOfferId => $qty) {
                $lineas[$productOfferId] = ($lineas[$productOfferId] ?? 0) + (int)$qty;
            }
        }

        $productOfferIds = array_keys($lineas);

        $productOffers = ProductOffer::with("product")
            ->whereIn("id", $productOfferIds)
            ->get()
            ->keyBy("id");

        $total = 0;
        foreach ($lineas as $productOfferId => $qty) {
            $po = $productOffers[$productOfferId] ?? null;
            if (!$po) continue;

            // si product_offers.price es null, usamos product.price
            $unit = $po->price ?? $po->product->price ?? 0;
            $total += ($unit * $qty);
        }

        // IMPORTANTE: tu tabla orders NO tiene status, así que NO lo guardamos
        $order = Order::create([
            "user_id" => Auth::id(),
            "total" => $total
        ]);

        foreach ($lineas as $productOfferId => $qty) {
            // product_orders.product_id guarda el id de product_offers
            ProductOrder::updateOrCreate(
                [
                    "order_id" => $order->id,
                    "product_id" => $productOfferId,
                ],
                [
                    "quantity" => $qty
                ]
            );
        }

        session()->forget("carrito");
        return redirect()->route("home_prieto");
    }
}
