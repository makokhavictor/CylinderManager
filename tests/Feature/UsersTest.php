<?php

namespace Tests\Feature;

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
     * @group users1
     * @test
     */
    public function user_can_register_with_phone_only()
    {
        $registeredUser = User::find(User::factory()->create()->id);
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => '',
            'phone' => $user->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'user' => ['id', 'firstName', 'lastName', 'email', 'phone'],
                    'token' => ['access_token', 'expires_in']
                ],
                'header' => ['message']
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
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => $user->email,
            'phone' => '',
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'user' => ['id', 'firstName', 'lastName', 'email', 'phone'],
                    'token' => ['access_token', 'expires_in']
                ]
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
        $user = User::factory()->make();

        $response = $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'email' => $user->email,
            'phone' => $user->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'user' => ['id', 'firstName', 'lastName', 'email', 'phone'],
                'token' => ['access_token', 'expires_in']
            ]
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
        $user = User::factory()->make();

        $this->actingAs($registeredUser, 'api')->postJson('api/users', [
            'username' => $registeredUser->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
        ])->assertUnprocessable();
    }

}
