<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancellationChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellation_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_cancellation_charge_id')->nullable();
            $table->foreign('booking_cancellation_charge_id')->references('id')->on('booking_cancellation_charges')->onDelete('cascade');
            $table->integer('min_day')->nullable();
            $table->integer('max_day')->nullable();
            $table->integer('charge')->nullable();
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
        Schema::dropIfExists('cancellation_charges');
    }
}
