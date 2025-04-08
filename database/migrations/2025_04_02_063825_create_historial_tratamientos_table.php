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
        Schema::create('historial_tratamientos', function (Blueprint $table) {
            $table->id(); // Laravel usará 'id' como clave primaria automáticamente
            $table->unsignedBigInteger('id_cita');
            $table->unsignedBigInteger('id_tratamiento');
            $table->date('fecha_realizacion');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('id_cita')->references('id')->on('citas')->onDelete('cascade');
            $table->foreign('id_tratamiento')->references('id')->on('tratamientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_tratamientos');
    }
};
