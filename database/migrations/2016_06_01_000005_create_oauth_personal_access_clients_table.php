<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthPersonalAccessClientsTable extends Migration
{
    /**
     * The database schema.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('oauth_personal_access_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();
        });

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => 1,
            'created_at' => '2021-02-11 15:35:52',
            'updated_at' => '2021-02-11 15:35:52',
        ]);
        DB::table('oauth_clients')->insert([
            [
                'id' => 1,
                'user_id' => NULL,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'ty26GCdwbGFKQtgeTAxTxMey4j7JnkpJA05jE4Rt',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2021-02-11 15:35:52',
                'updated_at' => '2021-02-11 15:35:52',
                'provider' => NULL
            ],
            [
                'id' => 2,
                'user_id' => NULL,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'duK0bplTPn2BeyrsjX1939Y9OPIjPytEFUUNwjqD',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2021-02-11 15:35:52',
                'updated_at' => '2021-02-11 15:35:52',
                'provider' => 'users'

            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('oauth_personal_access_clients');
    }

    /**
     * Get the migration connection name.
     *
     * @return string|null
     */
    public function getConnection()
    {
        return config('passport.storage.database.connection');
    }
}
