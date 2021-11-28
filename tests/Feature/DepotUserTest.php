<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DepotUser;
use Tests\TestCase;

class DepotUserTest extends TestCase
{
    /**
     * POST api/depot/:depot/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_with_permission_can_create_depotUser()
    {
        $depotUser = DepotUser::factory()->make();
        $newDepotUser = User::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create depot user');
        $response = $this->actingAs($user, 'api')
            ->postJson("/api/depots/{$depotUser->depot->id}/users", [
                'username' => $newDepotUser->username,
                'firstName' =>$newDepotUser->first_name,
                'lastName' => $newDepotUser->last_name,
                'email' => $newDepotUser->email,
                'phone' => $newDepotUser->phone,
            ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'firstName', 'lastName', 'username', 'email', 'phone', 'depotUserId'],
            'headers' => ['message']
        ]);
    }

    /**
     * POST api/depot/$depotUser/users
     *
     * @test
     * @return void
     */
    public function if_depotUser_EPRALicence_not_provided_returns_unprocessable()
    {
        $depotUser = DepotUser::factory()->make();
        $newDepotUser = User::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create depot user');
        $response = $this->actingAs($user, 'api')
            ->postJson("/api/depots/{$depotUser->depot->id}/users", [
                'depotUserName' => $newDepotUser->name,
                'depotUserCode' => $newDepotUser->code,
                'depotUserLocation' => $newDepotUser->location,
            ]);
        $response->assertUnprocessable();
    }

    /**
     * GET api/depot/$depotUser/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_depotUsers()
    {
        $depotUser = DepotUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/depots/{$depotUser->depot->id}/users");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [['id']]]);
        $response->assertJsonFragment(['id' => $depotUser->id]);
    }

    /**
     * GET api/depot/$depotUser/users/:depotUser
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_depotUser()
    {
        $depotUser = DepotUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/depots/{$depotUser->depot->id}/users/{$depotUser->user->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'firstName',
            'lastName',
            'username',
            'email',
            'phone'
        ]]);
        $response->assertJsonFragment(['depotUserId' => $depotUser->id]);
    }

    /**
     * PATCH api/depot/$depotUser/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_edit_their_depotUser_registration_details()
    {
        $depotUser = DepotUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('update depot user');
        $userEdit = User::factory()->make();
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/depots/{$depotUser->depot->id}/users/{$depotUser->user->id}", [
                'username' => $userEdit->username,
                'firstName' =>$userEdit->first_name,
                'lastName' => $userEdit->last_name,
                'email' => $userEdit->email,
                'phone' => $userEdit->phone,
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'username',
                'firstName',
                'lastName',
                'email',
                'phone'
            ],
            'headers' => [
                'message'
            ]
        ]);

        $this->assertTrue(DepotUser::find($depotUser->id)->user->first_name === "$userEdit->first_name", 'DepotUser not updated after patch request');

    }

    /**
     * DELETE api/depot/$depotUser/users
     *
     * @test
     * @return void
     */
    public function users_with_permission_can_delete_depotUser()
    {
        $depotUser = DepotUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('delete depot user');
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/depots/{$depotUser->depot->id}/users/{$depotUser->user->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(DepotUser::find($depotUser->id) === null, 'DepotUser not deleted after delete request');

    }

    /**
     * DELETE api/depot/$depotUser/users
     *
     * @test
     * @return void
     */
    public function users_without_permission_cannot_delete_depotUser()
    {
        $depotUser = DepotUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/depots/{$depotUser->depot->id}/users/{$depotUser->user->id}");
        $response->assertForbidden();

    }
}
