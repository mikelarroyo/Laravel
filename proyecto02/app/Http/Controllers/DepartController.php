<?php

namespace App\Http\Controllers;

use App\Models\Depart;
use Illuminate\Http\Request;

class DepartController extends Controller
{
    public function index()
    {
        $departs = Depart::all();
        return view("departs.index", compact("departs"));
    }
    public function create()
    {
        return view("departs.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            "depart_no" => "required|integer",
            "dnombre" => "required|string",
            "loc" => "required|string"
        ]);

        $depart = new Depart();

        $depart->depart_no = $request["depart_no"];
        $depart->dnombre = $request["dnombre"];
        $depart->loc = $request["loc"];
        $depart->save();
        return redirect()->route("departs.index");
    }
    public function show($id) {}
    public function edit($id)
    {
        $depart = Depart::find($id);
        return view("departs.edit", compact("depart"));
    }
    public function update($id, Request $request)
    {
        $request->validate([
            "dnombre" => "required|string",
            "loc" => "required|string"
        ]);

        Depart::find($id)->update([
            "dnombre" => $request["dnombre"],
            "loc" => $request["loc"],
        ]);
        return redirect()->route("departs.index");
    }
    public function destroy($id)
    {
        try {
            Depart::findOrFail($id)->delete();
            return redirect()->route("departs.index");
        } catch (\Exception $e) {
            error_log("error al borrar " . $e->getMessage());
            return redirect()->route("departs.index")->with("error", "el departamento no se pudo borrar");
        }
    }
}
