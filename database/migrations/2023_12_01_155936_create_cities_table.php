<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        // Verificar si la tabla ya existe
        if (!Schema::hasTable('cities')) {
            // Crear la tabla solo si no existe
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('Name');
                $table->char('CountryCode', 3);
                $table->string('District');
                $table->integer('Population');
                $table->foreign('CountryCode')->references('Code')->on('countries');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('city');
    }
}
