<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpTimEventDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_tim_event_details', function (Blueprint $table) {
            $table->id('id_tmp_tim_event_detail');
            $table->bigInteger('tim_event_id')->unsigned();
            $table->char('nim', 20)->nullable();
            $table->bigInteger('participant_id')->unsigned()->nullable();
            $table->char('role', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_tim_event_details');
    }
}
