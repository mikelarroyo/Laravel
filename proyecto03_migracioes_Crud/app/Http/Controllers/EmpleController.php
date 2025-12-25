<?php

namespace App\Http\Controllers;

use App\Models\Emple;
use App\Models\Depart;
use Illuminate\Http\Request;

class EmpleController extends Controller
{
    public function index()
    {
        $emples = Emple::with(["depart", "director"])->get();
        // dd($emples->first()->director);
        // dd($emples);
        return view("emples.index", compact("emples"));
    }
    public function create()
    {
        $departs = Depart::all();
        $directores = Emple::all();
        return view("emples.create", compact("departs", "directores"));
    }
    public function store(Request $request)
    {
        $request->validate([
            "emple_no" => "required|integer",
            "apellido" => "required|string",
            "oficio" => "required|string",
            "dir" => "integer|exists:emples,emple_no|nullable",
            "fecha_alt" => "required|date",
            "salario" => "required|numeric",
            "comision" => "nullable|numeric",
            "depart_no" => "required|integer|exists:departs,depart_no",
            "foto" => "nullable|mimes:jpg,jpeg,png|max:2048"
        ]);

        $file = $request->file('foto');
        $fotoRuta = null;

        if ($file) {
            $fotoRuta = $file->store('uploads', 'public');
        }

        Emple::create([
            "emple_no" => $request["emple_no"],
            "apellido" => $request["apellido"],
            "oficio" => $request["oficio"],
            "dir" => $request["dir"],
            "fecha_alt" => $request["fecha_alt"],
            "salario" => $request["salario"],
            "comision" => $request["comision"],
            "depart_no" => $request["depart_no"],
            "foto" => $fotoRuta
        ]);

        return redirect()->route("emples.index");
    }


    public function show($id) {}
    public function edit($id)
    {
        $departs = Depart::all();
        $directores = Emple::all();
        $emple = Emple::find($id);
        return view("emples.edit", compact("departs", "directores", "emple"));
    }
    public function update($id, Request $request)
    {
        $request->validate([
            "apellido" => "required|string",
            "oficio" => "required|string",
            "dir" => "integer|exists:emples,emple_no",
            "fecha_alt" => "required|date",
            "salario" => "required|numeric",
            "comision" => "required|numeric",
            "depart_no" => "required|integer|exists:departs,depart_no"
        ]);

        Emple::find($id)->update([
            "apellido" => $request["apellido"],
            "oficio" => $request["oficio"],
            "dir" => $request["dir"],
            "fecha_alt" => $request["fecha_alt"],
            "salario" => $request["salario"],
            "comision" => $request["comision"],
            "depart_no" => $request["depart_no"],
        ]);
        return redirect()->route("emples.index");
    }
    public function destroy($id)
    {
        try {
            $emple = Emple::findOrFail($id);

            // Quitar este empleado como director de otros
            Emple::where('dir', $emple->emple_no)->update(['dir' => null]);

            $emple->delete();

            return redirect()->route("emples.index");
        } catch (\Exception $e) {
            error_log("error al borrar " . $e->getMessage());
            return redirect()
                ->route("emples.index")
                ->with("error", "No se puede borrar porque es director de otros empleados");
        }
    }
}
