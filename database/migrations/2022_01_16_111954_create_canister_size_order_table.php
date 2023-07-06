<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanisterSizeOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canister_size_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canister_size_id');
            $table->foreign('canister_size_id')->references('id')->on('canister_sizes');
            $table->foreignId('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreignId('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('canister_size_order');
    }
}
