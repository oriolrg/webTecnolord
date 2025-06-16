<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Meteo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meteo', function (Blueprint $table) {
            $table->id();
            $table->string('humidity');
            $table->string('dew_point');
            $table->string('feels_like');
            $table->string('temperature');
            $table->string('rain_rate');
            $table->string('daily');
            $table->string('event');
            $table->string('hourly');
            $table->string('weekly');
            $table->string('monthly');
            $table->string('relative');
            $table->string('absolute');
            $table->string('uvi');
            $table->string('solar');
            $table->string('wind_speed');
            $table->string('wind_gust');
            $table->string('wind_direction');
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
        Schema::dropIfExists('meteo');
    }
}
