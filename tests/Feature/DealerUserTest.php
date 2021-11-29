<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DealerUser;
use Tests\TestCase;

class DealerUserTest extends TestCase
{

    /**
     * POST api/dealer/:dealer/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_with_permission_can_create_dealerUser()
    {
        $dealerUser = DealerUser::factory()->make();
        $newDealerUser = User::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create dealer user');
        $response = $this->actingAs($user, 'api')
            ->postJson("/api/dealers/{$dealerUser->dealer->id}/users", [
                'username' => $newDealerUser->username,
                'firstName' =>$newDealerUser->first_name,
                'lastName' => $newDealerUser->last_name,
                'email' => $newDealerUser->email,
                'phone' => $newDealerUser->phone,
            ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'firstName', 'lastName', 'username', 'email', 'phone', 'dealerUserId'],
            'headers' => ['message']
        ]);
    }

    /**
     * POST api/dealer/$dealerUser/users
     *
     * @test
     * @return void
     */
    public function if_dealerUser_EPRALicence_not_provided_returns_unprocessable()
    {
        $dealerUser = DealerUser::factory()->make();
        $newDealerUser = User::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create dealer user');
        $response = $this->actingAs($user, 'api')
            ->postJson("/api/dealers/{$dealerUser->dealer->id}/users", [
                'dealerUserName' => $newDealerUser->name,
                'dealerUserCode' => $newDealerUser->code,
                'dealerUserLocation' => $newDealerUser->location,
            ]);
        $response->assertUnprocessable();
    }

    /**
     * GET api/dealer/$dealerUser/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_dealerUsers()
    {
        $dealerUser = DealerUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/dealers/{$dealerUser->dealer->id}/users");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [['id']]]);
        $response->assertJsonFragment(['id' => $dealerUser->id]);
    }

    /**
     * GET api/dealer/$dealerUser/users/:dealerUser
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_dealerUser()
    {
        $dealerUser = DealerUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/dealers/{$dealerUser->dealer->id}/users/{$dealerUser->user->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'firstName',
            'lastName',
            'username',
            'email',
            'phone'
        ]]);
        $response->assertJsonFragment(['dealerUserId' => $dealerUser->id]);
    }

    /**
     * PATCH api/dealer/$dealerUser/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_edit_their_dealerUser_registration_details()
    {
        $dealerUser = DealerUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('update dealer user');
        $userEdit = User::factory()->make();
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/dealers/{$dealerUser->dealer->id}/users/{$dealerUser->user->id}", [
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

        $this->assertTrue(DealerUser::find($dealerUser->id)->user->first_name === "$userEdit->first_name", 'DealerUser not updated after patch request');

    }

    /**
     * DELETE api/dealer/$dealerUser/users
     *
     * @test
     * @return void
     */
    public function users_with_permission_can_delete_dealerUser()
    {
        $dealerUser = DealerUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('delete dealer user');
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/dealers/{$dealerUser->dealer->id}/users/{$dealerUser->user->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(DealerUser::find($dealerUser->id) === null, 'DealerUser not deleted after delete request');

    }

    /**
     * DELETE api/dealer/$dealerUser/users
     *
     * @test
     * @return void
     */
    public function users_without_permission_cannot_delete_dealerUser()
    {
        $dealerUser = DealerUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/dealers/{$dealerUser->dealer->id}/users/{$dealerUser->user->id}");
        $response->assertForbidden();

    }
}
