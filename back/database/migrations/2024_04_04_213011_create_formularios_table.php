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
        Schema::create('formularios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('codtramite')->nullable();
            $table->string('distrito')->nullable();
            $table->string('detalle')->nullable();
            $table->string('observacion')->nullable();
            $table->string('habilita')->nullable();
            $table->string('estado');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('tramite_id')->nullable();
            $table->foreign('tramite_id')->references('id')->on('tramites');

            $table->unsignedBigInteger('propietario_id')->nullable();
            $table->foreign('propietario_id')->references('id')->on('propietarios');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('cargo_id')->nullable();
            $table->foreign('cargo_id')->references('id')->on('cargos');
                                                                                                                                                                                                
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
