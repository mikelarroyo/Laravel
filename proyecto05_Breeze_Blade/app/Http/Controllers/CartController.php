<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class CartController extends Controller
{

    public function index()
    {

        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));

    }


}
