<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->date('dob')->nullable();           
            $table->date('anniversary')->nullable();
            $table->longText('more_details')->nullable();
            $table->longText('address')->nullable();
            $table->longText('meal_plan')->nullable();
            $table->longText('total_traveller')->nullable();
            $table->date('travel_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            //
        });
    }
}
