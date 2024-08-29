<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIternariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iternaries', function (Blueprint $table) {
            $table->id();
              $table->unsignedBigInteger('destination_iternarie_id')->nullable();
            $table->foreign('destination_iternarie_id')->references('id')->on('destination_iternaries')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->longText('text')->nullable();
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
        Schema::dropIfExists('iternaries');
    }
}
