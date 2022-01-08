<?php

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Role;
use App\Models\Transporter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('roleable_id')->nullable();
            $table->string('roleable_type');
            $table->foreignId('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });

        DB::table('station_roles')->insert([
            [ 'roleable_type' => Depot::class, 'role_id' => Role::where(['name' => 'Depot Admin User'])->first()->id],
            [ 'roleable_type' => Depot::class, 'role_id' => Role::where(['name' => 'Depot User'])->first()->id],
            [ 'roleable_type' => Dealer::class, 'role_id' => Role::where(['name' => 'Dealer Admin User'])->first()->id],
            [ 'roleable_type' => Dealer::class, 'role_id' => Role::where(['name' => 'Dealer User'])->first()->id],
            [ 'roleable_type' => Transporter::class, 'role_id' => Role::where(['name' => 'Transporter Admin User'])->first()->id],
            [ 'roleable_type' => Transporter::class, 'role_id' => Role::where(['name' => 'Transporter User'])->first()->id],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('station_roles');
    }
}
