<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventInternalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_internal_details', function (Blueprint $table) {
            $table->id('id_event_internal_detail');
            $table->bigInteger('event_internal_id')->unsigned();
            $table->boolean('is_validated_pembina');
            $table->boolean('is_validated_wadir3');
            $table->timestamps();

            $table->foreign('event_internal_id')->references('id_event_internal')->on('event_internals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_internal_details');
    }
}
