<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            // $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedInteger('saletype_id');
            // $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedInteger('jobnumber')->unique();;
            $table->float('amount');
            $table->float('commission');
            $table->date('dateofsale');
            $table->softDeletes();
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
        Schema::dropIfExists('sales');
    }
}
