<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandDepotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_depot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->foreignId('depot_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('depot_id')->references('id')->on('depots');
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
        Schema::dropIfExists('brand_depot');
    }
}
