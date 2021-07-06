<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEksternalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_eksternal_details', function (Blueprint $table) {
            $table->id('id_event_eksternal_detail');
            $table->bigInteger('event_eksternal_id')->unsigned();
            $table->boolean('is_validated_pembina');
            $table->boolean('is_validated_wadir3');
            $table->timestamps();

            $table->foreign('event_eksternal_id')->references('id_event_eksternal')->on('event_eksternals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_eksternal_details');
    }
}
