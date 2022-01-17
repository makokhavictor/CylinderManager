<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedColumnOnOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('accepted')->default(false);
            $table->foreignId('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('transporters');
            $table->dateTime('assigned_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('assigned_to');
            $table->dropColumn('assigned_at');
        });
    }
}
