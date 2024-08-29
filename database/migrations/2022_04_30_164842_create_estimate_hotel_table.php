<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_hotel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estimate_id')->nullable();
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->integer('adult')->nullable();
            $table->integer('child')->nullable();
            $table->integer('room')->nullable();
            $table->integer('bed')->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->string('destination')->nullable();
            $table->text('note')->nullable();
            $table->enum('inclusion_filter', ['normal', 'weekend', 'festival'])->default('normal');
            $table->enum('term_filter', ['normal', 'weekend', 'festival'])->default('normal');
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
        Schema::dropIfExists('estimate_hotel');
    }
}
