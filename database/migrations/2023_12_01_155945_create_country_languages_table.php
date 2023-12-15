<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryLanguagesTable extends Migration
{
    public function up()
    {
        // Verificar si la tabla ya existe
        if (!Schema::hasTable('countrylanguages')) {
            // Crear la tabla solo si no existe
            Schema::create('countrylanguages', function (Blueprint $table) {
                $table->char('CountryCode', 3)->primary();
                $table->string('Language');
                $table->enum('IsOfficial', ['T', 'F'])->default('F');
                $table->decimal('Percentage', 4, 1);
                $table->foreign('CountryCode')->references('Code')->on('countries');
            });
        }
    }

    public function down()
    {
        // Revertir la creación de la tabla solo si existe
        if (Schema::hasTable('countrylanguages')) {
            Schema::dropIfExists('countrylanguages');
        }
    }
}
