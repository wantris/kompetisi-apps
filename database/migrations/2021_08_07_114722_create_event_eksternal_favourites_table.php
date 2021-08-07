<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEksternalFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_eksternal_favourites', function (Blueprint $table) {
            $table->id('id_event_eksternal_favourites');
            $table->bigInteger('event_eksternal_id')->unsigned();
            $table->bigInteger('pengguna_id')->unsigned();
            $table->timestamps();

            $table->foreign('event_eksternal_id')->references('id_event_eksternal')->on('event_eksternals')->onDelete('cascade');
            $table->foreign('pengguna_id')->references('id_pengguna')->on('penggunas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_eksternal_favourites');
    }
}
