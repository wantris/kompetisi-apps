<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileEventInternalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_event_internal_regis', function (Blueprint $table) {
            $table->id('id_file_event_internal_regis');
            $table->bigInteger('event_internal_regis_id')->unsigned();
            $table->string('filename', 255);
            $table->timestamps();

            $table->foreign('event_internal_regis_id')->references('id_event_internal_registration')->on('event_internal_registrations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_event_internal_registrations');
    }
}
