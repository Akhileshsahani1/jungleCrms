<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('website')->nullable();
            $table->text('meta')->nullable();
            $table->enum('source', ['website', 'crm'])->default('crm');
            $table->integer('lead_status')->default(0);
            $table->enum('payment_status',['paid','waiting', 'partially paid'])->default('waiting');
            $table->unsignedBigInteger('assigned_to')->default(2);
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->date('date_assigned')->nullable();
            $table->date('date');
            $table->time('time');
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
        Schema::dropIfExists('leads');
    }
}
