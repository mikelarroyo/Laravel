<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depart extends Model
{
    // protected $table = "departs2";
    public $incrementing = false;
    protected $primaryKey = "depart_no";
    public $timestamps = false;
    protected $fillable = [
        "depart_no",
        "dnombre",
        "loc",
    ];

    public function emple()
    {
        return $this->hasMany(Emple::class, "depart_no");
    }
}
