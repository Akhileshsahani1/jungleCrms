<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceInEstimateFlightOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estimate_flight_options', function (Blueprint $table) {
             $table->integer('price')->default(0);
             $table->integer('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimate_flight_options', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('discount');
        });
    }
}
