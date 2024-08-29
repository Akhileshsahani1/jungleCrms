<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_address', function (Blueprint $table) {
            $table->id();
            $table->enum('sanctuary', ['gir', 'jim', 'ranthambore','tadoba','dailytour'])->nullable();
            $table->string('name');
            $table->longText('address_1')->nullable();
            $table->longText('address_2')->nullable();
            $table->string('state')->nullable();
            $table->bigInteger('pincode')->nullable();
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
        Schema::dropIfExists('local_address');
    }
}
