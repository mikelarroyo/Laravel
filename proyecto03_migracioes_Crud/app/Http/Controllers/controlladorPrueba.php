<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Depart;

class controlladorPrueba extends Controller
{
    public function saludo($nombre= "Invitado"){
        return "Hola, $nombre, desde el controlador de prueba";
    }
    public function mostrar(Depart $id){
        if ($id){
            return "El Departamento es, " . $id->dnombre;
        }
        return "Departamento, NULL";
    }

}
