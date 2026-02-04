<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Offer;

class PrietoController extends Controller
{
    public function mostrar()
    {
        $offers = Offer::with("productsOffer.product")
            ->whereDate("date_delivery", ">=", now()->toDateString())
            ->orderBy("date_delivery", "asc")
            ->orderBy("time_delivery", "asc")
            ->get();


        $platos = Product::all();

        return view("home", compact("offers", "platos"));
    }


    // LOGIN
    public function create()
    {
        return view('login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended('/prieto');
    }

    // REGISTER
    public function register()
    {
        return view('register');
    }

    public function storeRegister(Request $request)
    {
        $credentials = $request->validate([
            "name" => "required|string|max:255",
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Debes ingresar un correo electrónico',
            'email.email' => 'El correo electrónico no es válido',
            'email.unique' => 'Este correo ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => "Las contraseñas no son iguales"
        ]);

        try {
            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => bcrypt($credentials['password']),
                "is_admin" => false,
            ]);

            Auth::login($user);

            return redirect('/prieto');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'No se pudo crear el usuario. Intente de nuevo.']);
        }
    }

    // LOGOUT
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/prieto');
    }

    public function ordersShow()
    {
        // cargamos también productOffer + product para poder pintarlo después
        $orders = Order::with("products.productOffer.product")
            ->where('user_id', Auth::id())
            ->get();

        return view('pedidos', compact('orders'));
    }
}
