<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('canisters', function (Blueprint $table) {
            $table->dropColumn('recertification');
            $table->date('recertification_date')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('canisters', function (Blueprint $table) {
            $table->string('recertification');
            $table->dropColumn('recertification_date');
        });
    }
};
