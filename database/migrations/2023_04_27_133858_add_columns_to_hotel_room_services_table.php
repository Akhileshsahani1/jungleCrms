<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHotelRoomServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_room_services', function (Blueprint $table) {
            $table->string('weekend_price')->nullable();
            $table->string('extra_adult_weekend_price')->nullable();
            $table->string('extra_child_weekend_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_room_services', function (Blueprint $table) {
            //
        });
    }
}
