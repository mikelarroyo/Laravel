<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <--- Importante para usar DB::select

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{

    $menus = DB::select("SELECT * FROM products WHERE available = true AND product_type = 'menu'");
    $platos = DB::select("SELECT * FROM products WHERE available = true AND product_type = 'carta'");

    return view('home', compact('menus', 'platos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
