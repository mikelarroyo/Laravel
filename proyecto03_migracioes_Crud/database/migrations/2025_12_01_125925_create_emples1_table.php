<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emples', function (Blueprint $table) {
            $table->integer("emple_no")->primary();
            $table->string("apellido", 10);
            $table->string("oficio", 10);
            $table->integer("dir")->nullable();
            $table->date("fecha_alt");
            $table->decimal("salario", 6, 2);
            $table->decimal("comision", 6, 2)->nullable();
            $table->integer("depart_no");
            // $table->timestamps();
            $table->foreign("depart_no")->references("depart_no")->on("departs");
            $table->foreign("dir")->references("emple_no")->on("emples");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emples');
    }
};
