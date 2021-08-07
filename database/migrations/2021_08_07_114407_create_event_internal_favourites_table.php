<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventInternalFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_internal_favourites', function (Blueprint $table) {
            $table->id('id_event_internal_favourites');
            $table->bigInteger('event_internal_id')->unsigned();
            $table->bigInteger('pengguna_id')->unsigned();
            $table->timestamps();

            $table->foreign('event_internal_id')->references('id_event_internal')->on('event_internals')->onDelete('cascade');
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
        Schema::dropIfExists('event_internal_favourites');
    }
}
