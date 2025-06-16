<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pluja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meteo_pluja', function (Blueprint $table) {
            $table->id();
            $table->string('rain_rate');
            $table->string('daily');
            $table->string('event');
            $table->string('hourly');
            $table->string('weekly');
            $table->string('monthly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meteo_pluja');
    }
}
