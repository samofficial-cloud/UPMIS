<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationalExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operational_expenditures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vehicle_reg_no');
            $table->string('lpo_no');
            $table->string('service_provider');
            $table->string('date_received');
            $table->string('fuel_consumed');
            $table->string('amount');
            $table->string('total');
             $table->string('description');
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
        Schema::dropIfExists('operational_expenditures');
    }
}
