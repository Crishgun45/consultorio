<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('historial_tratamientos', function (Blueprint $table) {
            $table->dropForeign(['id_tratamiento']); // Elimina la clave foránea si existe
            $table->dropColumn('id_tratamiento'); // Elimina la columna
        });
    }

    public function down()
    {
        Schema::table('historial_tratamientos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tratamiento')->nullable();
            $table->foreign('id_tratamiento')->references('id')->on('tratamientos')->onDelete('cascade');
            $table->dropColumn('motivo');
        });
    }
};
