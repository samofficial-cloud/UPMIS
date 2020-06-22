<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullName');
            $table->string('vehicle_reg_no');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('special_condition');
            $table->string('amount');
            $table->string('rate');
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
        Schema::dropIfExists('car_contracts');
    }
}
