<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToEventInternals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_internals', function (Blueprint $table) {
            $table->string('slug', 100)->after('nama_event');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_internals', function (Blueprint $table) {
            // 2. Drop the column
            $table->dropColumn('slug');
        });
    }
}
