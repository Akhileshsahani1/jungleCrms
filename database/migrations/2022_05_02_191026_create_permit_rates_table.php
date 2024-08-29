<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermitRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('sanctuary', ['gir', 'jim', 'ranthambore','tadoba'])->nullable();
            $table->enum('type', ['normal', 'weekend'])->default('normal')->nullable();
            $table->enum('nationality', ['indian', 'foreigner'])->default('indian')->nullable();
            $table->string('price');
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
        Schema::dropIfExists('permit_rates');
    }
}
