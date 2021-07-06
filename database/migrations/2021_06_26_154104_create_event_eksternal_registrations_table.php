<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEksternalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_eksternal_registrations', function (Blueprint $table) {
            $table->id('id_event_eksternal_registration');
            $table->bigInteger('event_eksternal_id')->unsigned();
            $table->char('nim', 20)->nullable();
            $table->bigInteger('tim_event_id')->unsigned()->nullable();
            $table->json('is_win');

            $table->timestamps();

            $table->foreign('event_eksternal_id')->references('id_event_eksternal')->on('event_eksternals')->onDelete('cascade');
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
        Schema::dropIfExists('event_eksternal_registrations');
    }
}
