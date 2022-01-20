<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdColumnOnCanisterLogBatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('canister_log_batches', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('canister_log_batches', function (Blueprint $table) {
            $table->dropForeign('canister_log_batches_order_id_foreign');
            $table->dropColumn('order_id');
        });
    }
}
