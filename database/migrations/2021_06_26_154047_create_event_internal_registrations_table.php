<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventInternalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_internal_registrations', function (Blueprint $table) {
            $table->id('id_event_internal_registration');
            $table->bigInteger('event_internal_id')->unsigned();
            $table->char('nim', 20)->nullable();
            $table->bigInteger('participant_id')->unsigned()->nullable();
            $table->bigInteger('tim_event_id')->unsigned()->nullable();
            $table->json('is_win');

            $table->timestamps();

            $table->foreign('event_internal_id')->references('id_event_internal')->on('event_internals')->onDelete('cascade');
            $table->foreign('participant_id')->references('id_participant')->on('participants')->onDelete('cascade');
            $table->foreign('tim_event_id')->references('id_tim_event')->on('tim_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_internal_registrations');
    }
}
