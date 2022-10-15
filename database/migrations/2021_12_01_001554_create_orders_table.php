<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('depot_id');
            $table->foreign('depot_id')->references('id')->on('depots');
            $table->foreignId('dealer_id');
            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->dateTime('accepted_at')->nullable();
            $table->foreignId('accepted_by')->nullable();
            $table->foreign('accepted_by')->references('id')->on('users');
            $table->foreignId('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('transporters');
            $table->dateTime('assigned_at')->nullable();

            $table->boolean('depot_transporter_ok')->nullable();
            $table->boolean('transporter_dealer_ok')->nullable();
            $table->boolean('dealer_transporter_ok')->nullable();
            $table->boolean('transporter_depot_ok')->nullable();

            $table->dateTime('depot_transporter_ok_at')->nullable();
            $table->dateTime('transporter_dealer_ok_at')->nullable();
            $table->dateTime('dealer_transporter_ok_at')->nullable();
            $table->dateTime('transporter_depot_ok_at')->nullable();

            $table->dateTime('declined_at')->nullable();
            $table->foreignId('declined_by')->nullable();
            $table->foreign('declined_by')->references('id')->on('users');

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
        Schema::dropIfExists('orders');
    }
}
