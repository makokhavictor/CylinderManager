<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanisterLogBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canister_log_batches', function (Blueprint $table) {
            $table->id();
            $table->integer('toable_id');
            $table->string('toable_type');
            $table->integer('fromable_id');
            $table->string('fromable_type');
            $table->string('transporter_id');
            $table->boolean('received')->default(false);
            $table->foreignId('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('canister_log_batches');
    }
}
