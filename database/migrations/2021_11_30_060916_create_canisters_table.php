<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canisters', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('manuf');
            $table->date('manuf_date');
            $table->foreignId('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->string('RFID');
            $table->string('recertification');
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
        Schema::dropIfExists('canisters');
    }
}
