<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateSafariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_safari', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estimate_id')->nullable();
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
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
        Schema::dropIfExists('estimate_safari');
    }
}
