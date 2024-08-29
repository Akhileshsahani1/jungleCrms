<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPackageNameToBookingSafariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_safari', function (Blueprint $table) {
            $table->string('package_name')->nullable();
            $table->string('package_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_safari', function (Blueprint $table) {
            $table->dropColumn('package_name');
            $table->dropColumn('package_type');
        });
    }
}
