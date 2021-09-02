<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatEventEksternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat_event_eksternals', function (Blueprint $table) {
            $table->id('id_sertif_eksternal');
            $table->bigInteger('event_eksternal_regis_id')->unsigned();
            $table->string('filename');
            $table->timestamps();

            $table->foreign('event_eksternal_regis_id')->references('id_event_eksternal_registration')->on('event_eksternal_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikat_event_eksternals');
    }
}
