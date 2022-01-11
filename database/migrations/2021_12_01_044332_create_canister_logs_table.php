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

            $table->integer('fromable_id')->nullable();
            $table->string('fromable_type')->nullable();
            $table->integer('toable_id');
            $table->string('toable_type');
            $table->foreignId('canister_id')->nullable();
            $table->foreign('canister_id')->references('id')->on('canisters');
            $table->boolean('filled')->default(false);
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('canister_log_batch_id');
            $table->foreign('canister_log_batch_id')->references('id')->on('canister_log_batches');
            $table->dateTime('released_at')->nullable();
            $table->integer('releasable_id')->nullable(); // ID of station the canister has been transfered to
            $table->string('releasable_type')->nullable();
//            $table->foreignId('released_to_depot_id')->nullable();
//            $table->foreignId('released_to_transporter_id')->nullable();
//            $table->foreignId('released_to_dealer_id')->nullable();
//            $table->foreign('released_to_depot_id')->references('id')->on('depots');
//            $table->foreign('released_to_transporter_id')->references('id')->on('transporters');
//            $table->foreign('released_to_dealer_id')->references('id')->on('dealers');
            $table->boolean('defective')->default(false);
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
