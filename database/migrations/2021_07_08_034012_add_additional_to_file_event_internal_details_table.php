<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalToFileEventInternalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_event_internal_details', function (Blueprint $table) {
            $table->string('nama_file', 100)->after('event_internal_detail_id');
            $table->enum('tipe', ['pengajuan','pendaftaran'])->after('filename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_event_internal_details', function (Blueprint $table) {
            //
        });
    }
}
