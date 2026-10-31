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
        Schema::create('simulacions', function (Blueprint $table) {
            $table->id();
            $table->string('algoritmo'); 
            $table->json('detalle_procesos'); 
            $table->decimal('espera_promedio', 8, 2);
            $table->decimal('retorno_promedio', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulacions');
    }
};
