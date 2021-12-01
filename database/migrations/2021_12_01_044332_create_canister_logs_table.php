<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanisterLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canister_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_depot_id')->nullable();
            $table->foreignId('from_transporter_id')->nullable();
            $table->foreignId('from_dealer_id')->nullable();
            $table->foreign('from_depot_id')->references('id')->on('depots');
            $table->foreign('from_transporter_id')->references('id')->on('transporters');
            $table->foreign('from_dealer_id')->references('id')->on('dealers');
            $table->foreignId('to_depot_id')->nullable();
            $table->foreignId('to_transporter_id')->nullable();
            $table->foreignId('to_dealer_id')->nullable();
            $table->foreign('to_depot_id')->references('id')->on('depots');
            $table->foreign('to_transporter_id')->references('id')->on('transporters');
            $table->foreign('to_dealer_id')->references('id')->on('dealers');
            $table->foreignId('canister_id')->nullable();
            $table->foreign('canister_id')->references('id')->on('canisters');
            $table->boolean('filled')->default(false);
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
        Schema::dropIfExists('canister_logs');
    }
}
