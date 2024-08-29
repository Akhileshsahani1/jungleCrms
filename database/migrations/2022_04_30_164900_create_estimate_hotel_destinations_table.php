<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateHotelDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_hotel_destinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estimate_id')->nullable();
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->unsignedBigInteger('estimate_hotel_id')->nullable();
            $table->foreign('estimate_hotel_id')->references('id')->on('estimate_hotel')->onDelete('cascade');
            $table->string('destination')->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->enum('accepted', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('estimate_hotel_destinations');
    }
}
