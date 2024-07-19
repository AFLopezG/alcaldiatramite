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
        Schema::create('rectificados', function (Blueprint $table) {
            $table->id();
            $table->timestamp('inicio');
            $table->timestamp('fin')->nullable();
            $table->string('orden');
            $table->string('descripcion');
            $table->unsignedBigInteger('formulario_id');
            $table->foreign('formulario_id')->references('id')->on('formularios');
            $table->unsignedBigInteger('proceso_id');
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rectificados');
    }
};
