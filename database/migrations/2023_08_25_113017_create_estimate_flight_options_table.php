<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateFlightOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_flight_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estimate_id')->nullable();
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->unsignedBigInteger('estimate_flight_id')->nullable();
            $table->enum('type', ['depart', 'return'])->nullable();
            $table->string('travel_date')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('travel_class')->nullable();
            $table->string('airport_name_from')->nullable();
            $table->string('airport_name_to')->nullable();
            $table->string('cancellation_charges')->nullable();
            $table->string('airline_name')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('reach_time')->nullable();
            $table->string('stops')->nullable();
            $table->string('flight_no')->nullable();
            $table->string('cabin_bag')->nullable();
            $table->string('bag_weight')->nullable();
            $table->string('cancellation')->nullable();
            $table->string('meal')->nullable();
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
        Schema::dropIfExists('estimate_flight_options');
    }
}
