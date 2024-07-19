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
        Schema::create('adjuntos', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->string('nombre');
            $table->string('orden');
            $table->boolean('baja')->default(false);
            $table->unsignedBigInteger('formulario_id');
            $table->foreign('formulario_id')->references('id')->on('formularios');
            $table->unsignedBigInteger('proceso_id');
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjuntos');
    }
};
