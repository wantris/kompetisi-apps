<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileEventInternalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_event_internal_details', function (Blueprint $table) {
            $table->id('id_file_event_internal_detail');
            $table->bigInteger('event_internal_detail_id')->unsigned();
            $table->string('filename', 255);
            $table->timestamps();

            $table->foreign('event_internal_detail_id')->references('id_event_internal_detail')->on('event_internal_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_event_details');
    }
}
