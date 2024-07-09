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
            //numeroi de contacto
            $table->integer('numero');
            $table->string('gestion');
            $table->string('codigo');
            $table->string('codtram');
            $table->string('distrito')->nullable();
            $table->string('detalle')->nullable();
            $table->string('observacion')->nullable();
;
            $table->string('estado');
            $table->date('fecha');
            $table->time('hora');

            $table->unsignedBigInteger('delegado_id')->nullable();
            $table->foreign('delegado_id')->references('id')->on('delegados');

            $table->unsignedBigInteger('tramite_id');
            $table->foreign('tramite_id')->references('id')->on('tramites');

            $table->unsignedBigInteger('propietario_id');
            $table->foreign('propietario_id')->references('id')->on('propietarios');

            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
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
