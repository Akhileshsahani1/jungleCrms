<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingCabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_cab', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->string('trip_type')->nullable();
            $table->string('pickup_medium')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('days')->nullable();
            $table->string('pick_up')->nullable();
            $table->string('drop')->nullable();
            $table->string('pickup_time')->nullable();
            $table->string('total_riders')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('no_of_cab')->default(1);
            $table->bigInteger('cab_due_amount')->default(0);
            $table->string('vendor_name')->nullable();
            $table->unsignedBigInteger('vendor_mobile')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('booking_cab');
    }
}
