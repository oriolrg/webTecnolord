<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectePublicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projecte_publics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descripcio');
            $table->string('client');
            $table->string('img_portada')->nullable();
            $table->string('img_interna_1')->nullable();
            $table->string('img_interna_2')->nullable();
            $table->string('img_interna_3')->nullable();
            $table->date('data_finalitzacio')->nullable();
            $table->integer('publicat')->default(0);
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
        Schema::dropIfExists('projecte_publics');
    }
}
