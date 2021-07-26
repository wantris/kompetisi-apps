<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileEventEksternalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_event_eksternal_regis', function (Blueprint $table) {
            $table->id('id_file_event_eksternal_regis');
            $table->bigInteger('event_eksternal_regis_id')->unsigned();
            $table->string('filename', 255);
            $table->timestamps();

            $table->foreign('event_eksternal_regis_id')->references('id_event_eksternal_registration')->on('event_eksternal_registrations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_event_eksternal_registrations');
    }
}
