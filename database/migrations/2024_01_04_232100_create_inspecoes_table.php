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
        Schema::create('inspecoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id');
            $table->foreignId('user_id');
            $table->foreignId('veiculo_id');
            $table->foreignId('modelo_veiculo_id');
            $table->string('uvs')->nullable();
            $table->float('horimetro')->nullable();
            $table->float('km')->nullable();
            $table->dateTime('data')->nullable();
            $table->string('turno')->nullable();
            $table->string('observacao')->nullable();
            $table->string('image',2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecoes');
    }
};
