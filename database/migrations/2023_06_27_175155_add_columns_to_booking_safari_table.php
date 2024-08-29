<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBookingSafariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_safari', function (Blueprint $table) {
            $table->string('no_of_room')->nullable();
            $table->string('extra_beds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_safari', function (Blueprint $table) {
            $table->dropColumn('no_of_room');
            $table->dropColumn('extra_beds');
        });
    }
}
