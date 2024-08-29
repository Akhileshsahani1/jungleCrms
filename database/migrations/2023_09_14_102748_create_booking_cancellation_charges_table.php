<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingCancellationChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_cancellation_charges', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['cab', 'hotel', 'safari', 'tour', 'package'])->nullable();
            $table->enum('filter', ['normal', 'weekend', 'festival', 'gir', 'jim', 'ranthambore','tadoba'])->nullable();
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('booking_cancellation_charges');
    }
}
