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
        Schema::create('requisito_tramite', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisito_id')->nullable();
            $table->foreign('requisito_id')->references('id')->on('requisitos');
            $table->unsignedBigInteger('tramite_id')->nullable();
            $table->foreign('tramite_id')->references('id')->on('tramites');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisito_tramite');
    }
};
