<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateSafariOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_safari_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estimate_id')->nullable();
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->unsignedBigInteger('estimate_safari_id')->nullable();
            $table->foreign('estimate_safari_id')->references('id')->on('estimate_safari')->onDelete('cascade');
            $table->text('content')->nullable();
            $table->unsignedBigInteger('amount')->nullable();
            $table->unsignedBigInteger('discount')->nullable();
            $table->unsignedBigInteger('total')->nullable();
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
        Schema::dropIfExists('estimate_safari_options');
    }
}
