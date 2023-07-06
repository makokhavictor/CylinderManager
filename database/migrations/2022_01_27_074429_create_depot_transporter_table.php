<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotTransporterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_transporter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transporter_id');
            $table->foreign('transporter_id')->references('id')->on('transporters');
            $table->foreignId('depot_id');
            $table->foreign('depot_id')->references('id')->on('depots');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
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
        Schema::dropIfExists('depot_transporter');
    }
}
