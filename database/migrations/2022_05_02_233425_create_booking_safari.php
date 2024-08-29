<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSafari extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_safari', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('vendor')->nullable();
            $table->foreign('vendor')->references('id')->on('vendors');
            $table->string('sanctuary')->nullable();
            $table->string('mode')->nullable();
            $table->string('zone')->nullable();
            $table->string('area')->nullable();
            $table->integer('adult')->nullable();
            $table->integer('child')->nullable();
            $table->integer('total_person')->nullable();
            $table->string('nationality')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('safari_due_amount')->nullable();
            $table->text('note')->nullable();
            $table->integer('jeeps')->default(1);
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
        Schema::dropIfExists('booking_safari');
    }
}
