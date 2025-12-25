<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emple extends Model
{
    public $incrementing = false;
    protected $primaryKey = "emple_no";
    public $timestamps = false;
    protected $fillable = [
        "emple_no",
        "apellido",
        "oficio",
        "dir",
        "fecha_alt",
        "salario",
        "comision",
        "depart_no",
    ];

    public function depart()
    {
        return $this->belongsTo(Depart::class, "depart_no");
    }

    public function director()
    {
        return $this->belongsTo(Emple::class, "dir");
    }

    public function empleados()
    {
        return $this->hasMany(Emple::class, "dir");
    }
}
