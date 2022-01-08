<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use App\Models\User;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * GET api/users
     * @test
     * @group users
     */

    public function authenticated_users_can_view_users()
    {
        $user = User::find(User::factory()->create()->id);
        User::factory()->count(4)->create();
        $response = $this->actingAs($user, 'api')->get('api/users');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [['id', 'firstName', 'lastName', 'username', 'email', 'phone']],
            'meta'
        ]);

    }


    /**
     * POST api/users
     * @group users
     * @test
     */
    public function user_can_register_with_phone_only()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => '',
            'phone' => $user->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertCreated()
            ->assertJsonStructure([
                'data' => ['id', 'firstName', 'lastName', 'email', 'phone'],
                'headers' => ['message']
            ]);
    }

    /**
     * POST api/users
     * @group auth
     * @test
     */
    public function user_can_register_with_email_only()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => $user->email,
            'phone' => '',
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertCreated()
            ->assertJsonStructure([
                'data' => ['id', 'firstName', 'lastName', 'email', 'phone'],
            ]);
    }

    /**
     * POST api/users
     * @group users
     * @test
     */
    public function user_can_register_with_both_email_and_phone()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $response = $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => $user->email,
            'phone' => $user->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'firstName', 'lastName', 'email', 'phone'],
            'headers' => ['message']
        ]);
    }

    /**
     * POST api/users
     * @group users
     * @test
     */
    public function returns_unprocessed_error_name_field_is_missing()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => '',
            'phone' => $user->phone,
            'name' => '',
        ])->assertUnprocessable();
    }

    /**
     * POST api/users
     * @group users
     * @test
     */
    public function returns_unprocessed_error_if_both_email_and_phone_field_is_missing()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => '',
            'phone' => '',
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertUnprocessable();
    }

    /**
     * POST api/users
     * @group users
     * @test
     */
    public function returns_unprocessed_error_when_phone_is_already_taken()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => '',
            'phone' => $registeredUser->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertUnprocessable();
    }

    /**
     * POST api/users
     * @group users
     * @test
     */
    public function returns_unprocessed_error_when_email_is_already_taken()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => $registeredUser->email,
            'phone' => '',
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertUnprocessable();
    }


    /**
     * POST api/users
     * @group users
     * @test
     */
    public function returns_unprocessed_error_when_username_is_already_taken()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'username' => $registeredUser->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertUnprocessable();
    }

    /**
     * POST api/users
     * @group users
     * @test
     */
    public function admin_can_register_depot_and_or_transporter_and_or_dealer()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $registeredUser->givePermissionTo('create user');
        $user = User::factory()->make();

        $transporter = Transporter::factory()->create();
        $transporter->assignDefaultUserRoles();

        $depot = Depot::factory()->create();
        $depot->assignDefaultUserRoles();

        $dealers = Dealer::factory()->count(2)->create();
        $dealers[0]->assignDefaultUserRoles();
        $dealers[1]->assignDefaultUserRoles();



        $response = $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => $user->email,
            'phone' => $user->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'stationSpecificRoles' => [
                ['transporterId' => $transporter->id, 'roleId' => $transporter->stationRoles[0]->role_id],
                ['depotId' => $depot->id, 'roleId' => $depot->stationRoles[0]->role_id],
                ['dealerId' => $dealers[0]->id, 'roleId' => $dealers[0]->stationRoles[0]->role_id],
                ['dealerId' => $dealers[1]->id, 'roleId' =>  $dealers[0]->stationRoles[0]->role_id],
            ],

        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'firstName', 'lastName', 'email', 'phone', 'stationSpecificRoles' => [['roleId', 'permissions']]
            ],
            'headers' => ['message']
        ]);
    }

}
