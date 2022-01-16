<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanisterSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canister_sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('canister_sizes')->insert([
            ['value' => 2, 'name' => '2Kg Cylinder'],
            ['value' => 3, 'name' => '3Kg Cylinder'],
            ['value' => 3.3, 'name' => '3.3Kg Cylinder'],
            ['value' => 3.7, 'name' => '3.7Kg Cylinder'],
            ['value' => 4.5, 'name' => '4.5Kg Cylinder'],
            ['value' => 4.7, 'name' => '4.7Kg Cylinder'],
            ['value' => 7, 'name' => '7Kg Cylinder'],
            ['value' => 9, 'name' => '9Kg Cylinder'],
            ['value' => 11, 'name' => '11Kg Cylinder'],
            ['value' => 12, 'name' => '12Kg Cylinder'],
            ['value' => 12.5, 'name' => '12.5Kg Cylinder'],
            ['value' => 13, 'name' => '13Kg Cylinder'],
            ['value' => 15.3, 'name' => '15.3Kg Cylinder'],
            ['value' => 18, 'name' => '18Kg Cylinder'],
            ['value' => 23.2, 'name' => '23.2Kg Cylinder'],
            ['value' => 45, 'name' => '45Kg Cylinder'],
            ['value' => 46.5, 'name' => '46.5Kg Cylinder'],
            ['value' => 90, 'name' => '90Kg Cylinder'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canister_sizes');
    }
}
