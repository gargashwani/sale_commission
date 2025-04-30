<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCommissionFromEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // We'll keep the commission column as a fallback/default value
        // No changes needed in the up() method
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No changes needed in the down() method
    }
}
