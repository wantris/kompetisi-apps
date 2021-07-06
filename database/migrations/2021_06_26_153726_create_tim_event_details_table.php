<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimEventDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_event_details', function (Blueprint $table) {
            $table->bigInteger('tim_event_id')->unsigned();
            $table->char('nim', 20)->nullable();
            $table->bigInteger('participant_id')->unsigned()->nullable();
            $table->char('role', 50);
            $table->timestamps();

            $table->foreign('tim_event_id')->references('id_tim_event')->on('tim_events')->onDelete('cascade');
            $table->foreign('participant_id')->references('id_participant')->on('participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tim_event_details');
    }
}
