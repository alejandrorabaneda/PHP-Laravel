<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->char('Code', 3)->primary();
            $table->string('Name');
            $table->enum('Continent', ['Asia', 'Europe', 'North America', 'Africa', 'Oceania', 'Antarctica', 'South America'])->default('Asia');
            $table->string('Region');
            $table->decimal('SurfaceArea', 10, 2);
            $table->smallInteger('IndepYear')->nullable();
            $table->integer('Population');
            $table->decimal('LifeExpectancy', 3, 1)->nullable();
            $table->decimal('GNP', 10, 2)->nullable();
            $table->decimal('GNPOld', 10, 2)->nullable();
            $table->string('LocalName');
            $table->string('GovernmentForm');
            $table->string('HeadOfState')->nullable();
            $table->integer('Capital')->nullable();
            $table->char('Code2', 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
