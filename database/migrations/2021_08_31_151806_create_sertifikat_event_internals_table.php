<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatEventInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat_event_internals', function (Blueprint $table) {
            $table->id('id_sertif_internal');
            $table->bigInteger('event_internal_regis_id')->unsigned();
            $table->string('filename');
            $table->timestamps();

            $table->foreign('event_internal_regis_id')->references('id_event_internal_registration')->on('event_internal_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikat_event_internals');
    }
}
