<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id');
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([PermissionRegistrar::$pivotPermission, PermissionRegistrar::$pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));

        DB::table($tableNames['roles'])->insert([
            ['name' => 'Super Admin', 'guard_name' => 'api'],
            ['name' => 'Admin', 'guard_name' => 'api'],
            ['name' => 'Transporter Admin User', 'guard_name' => 'api'],
            ['name' => 'Transporter User', 'guard_name' => 'api'],
            ['name' => 'Depot Admin User', 'guard_name' => 'api'],
            ['name' => 'Depot User', 'guard_name' => 'api'],
            ['name' => 'Dealer Admin User', 'guard_name' => 'api'],
            ['name' => 'Dealer User', 'guard_name' => 'api'],
        ]);

        DB::table($tableNames['permissions'])->insert([

            ['name' => 'create depot', 'guard_name' => 'api'],
            ['name' => 'update depot', 'guard_name' => 'api'],
            ['name' => 'delete depot', 'guard_name' => 'api'],

            ['name' => 'create dealer', 'guard_name' => 'api'],
            ['name' => 'update dealer', 'guard_name' => 'api'],
            ['name' => 'delete dealer', 'guard_name' => 'api'],

            ['name' => 'create transporter', 'guard_name' => 'api'],
            ['name' => 'update transporter', 'guard_name' => 'api'],
            ['name' => 'delete transporter', 'guard_name' => 'api'],

            ['name' => 'admin: create depot user', 'guard_name' => 'api'],
            ['name' => 'admin: update depot user', 'guard_name' => 'api'],
            ['name' => 'admin: delete depot user', 'guard_name' => 'api'],

            ['name' => 'create depot user', 'guard_name' => 'api'],
            ['name' => 'update depot user', 'guard_name' => 'api'],
            ['name' => 'delete depot user', 'guard_name' => 'api'],

            ['name' => 'admin: create transporter user', 'guard_name' => 'api'],
            ['name' => 'admin: update transporter user', 'guard_name' => 'api'],
            ['name' => 'admin: delete transporter user', 'guard_name' => 'api'],

            ['name' => 'create transporter user', 'guard_name' => 'api'],
            ['name' => 'update transporter user', 'guard_name' => 'api'],
            ['name' => 'delete transporter user', 'guard_name' => 'api'],

            ['name' => 'admin: create dealer user', 'guard_name' => 'api'],
            ['name' => 'admin: update dealer user', 'guard_name' => 'api'],
            ['name' => 'admin: delete dealer user', 'guard_name' => 'api'],

            ['name' => 'create dealer user', 'guard_name' => 'api'],
            ['name' => 'update dealer user', 'guard_name' => 'api'],
            ['name' => 'delete dealer user', 'guard_name' => 'api'],

            ['name' => 'admin: create canister', 'guard_name' => 'api'],
            ['name' => 'admin: update canister', 'guard_name' => 'api'],
            ['name' => 'admin: delete canister', 'guard_name' => 'api'],

            ['name' => 'create canister', 'guard_name' => 'api'],
            ['name' => 'update canister', 'guard_name' => 'api'],
            ['name' => 'delete canister', 'guard_name' => 'api'],

            ['name' => 'admin: create canister log', 'guard_name' => 'api'],
            ['name' => 'admin: update canister log', 'guard_name' => 'api'],
            ['name' => 'admin: delete canister log', 'guard_name' => 'api'],

            ['name' => 'create canister log', 'guard_name' => 'api'],
            ['name' => 'update canister log', 'guard_name' => 'api'],
            ['name' => 'delete canister log', 'guard_name' => 'api'],

            ['name' => 'admin: create refill order', 'guard_name' => 'api'],
            ['name' => 'admin: update refill order', 'guard_name' => 'api'],
            ['name' => 'admin: delete refill order', 'guard_name' => 'api'],
            ['name' => 'admin: accept refill order', 'guard_name' => 'api'],

            ['name' => 'create refill order', 'guard_name' => 'api'],
            ['name' => 'update refill order', 'guard_name' => 'api'],
            ['name' => 'delete refill order', 'guard_name' => 'api'],
            ['name' => 'accept refill order', 'guard_name' => 'api'],

            ['name' => 'create brand', 'guard_name' => 'api'],
            ['name' => 'update brand', 'guard_name' => 'api'],
            ['name' => 'delete brand', 'guard_name' => 'api'],

            ['name' => 'create user', 'guard_name' => 'api'],
            ['name' => 'update user', 'guard_name' => 'api'],
            ['name' => 'delete user', 'guard_name' => 'api'],

            ['name' => 'admin: dispatch canister', 'guard_name' => 'api'],
            ['name' => 'admin: receive dispatched canister', 'guard_name' => 'api'],
            ['name' => 'admin: confirm dispatch', 'guard_name' => 'api'],

            ['name' => 'dispatch canister', 'guard_name' => 'api'],
            ['name' => 'receive dispatched canister', 'guard_name' => 'api'],

            ['name' => 'admin: assign order', 'guard_name' => 'api'],
            ['name' => 'assign order', 'guard_name' => 'api'],
            ['name' => 'confirm dispatch from depot', 'guard_name' => 'api'],
            ['name' => 'confirm dispatch from dealer', 'guard_name' => 'api'],
            ['name' => 'admin: confirm dispatch from depot', 'guard_name' => 'api'],
            ['name' => 'admin: confirm dispatch from dealer', 'guard_name' => 'api'],

            ['name' => 'scan qr code', 'guard_name' => 'api'],
        ]);

        Role::where('name', 'Admin')->first()->givePermissionTo([
            'create depot',
            'update depot',
            'delete depot',

            'create dealer',
            'update dealer',
            'delete dealer',

            'create transporter',
            'update transporter',
            'delete transporter',

            'admin: create depot user',
            'admin: update depot user',
            'admin: delete depot user',

            'admin: create transporter user',
            'admin: update transporter user',
            'admin: delete transporter user',

            'admin: create dealer user',
            'admin: update dealer user',
            'admin: delete dealer user',

            'admin: create canister',
            'admin: update canister',
            'admin: delete canister',

            'admin: create canister log',
            'admin: update canister log',
            'admin: delete canister log',

            'admin: create refill order',
            'admin: update refill order',
            'admin: delete refill order',
            'admin: accept refill order',

            'create brand',
            'update brand',
            'delete brand',

            'create user',
            'update user',
            'delete user',

            'admin: dispatch canister',
            'admin: receive dispatched canister',
            'admin: confirm dispatch from dealer',
            'admin: confirm dispatch from depot',

            'admin: assign order',
            'assign order'

        ]);

        Role::where('name', 'Transporter Admin User')->first()->givePermissionTo([
            'create transporter user',
            'update transporter user',
            'delete transporter user',

            'confirm dispatch from depot',
            'confirm dispatch from dealer'

        ]);
        Role::where('name', 'Depot Admin User')->first()->givePermissionTo([
            'create depot user',
            'update depot user',
            'delete depot user',
            'create canister',
            'update canister',
            'assign order',
            'accept refill order',
            'dispatch canister'
        ]);
        Role::where('name', 'Dealer Admin User')->first()->givePermissionTo([
            'create dealer user',
            'update dealer user',
            'delete dealer user',

            'create refill order',
            'update refill order',
            'delete refill order',
        ]);
        Role::where('name', 'Depot User')->first()->givePermissionTo([
            'dispatch canister',
            'receive dispatched canister',
            'accept refill order'
        ]);

        Role::where('name', 'Dealer User')->first()->givePermissionTo([
            'dispatch canister',
            'receive dispatched canister',
            'create refill order',
            'update refill order'
        ]);

        Role::where('name', 'Transporter User')->first()->givePermissionTo([
            'confirm dispatch from depot',
            'confirm dispatch from dealer'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
