<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TransporterUser;
use Tests\TestCase;

class TransporterUserTest extends TestCase
{

    /**
     * POST api/transporters/:transporter/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_with_permission_can_create_transporter_user()
    {
        $transporterUser = TransporterUser::factory()->make();
        $newTransporterUser = User::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create transporter user');
        $response = $this->actingAs($user, 'api')
            ->postJson("/api/transporters/{$transporterUser->transporter->id}/users", [
                'username' => $newTransporterUser->username,
                'firstName' =>$newTransporterUser->first_name,
                'lastName' => $newTransporterUser->last_name,
                'email' => $newTransporterUser->email,
                'phone' => $newTransporterUser->phone,
            ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'firstName', 'lastName', 'username', 'email', 'phone', 'transporterUserId'],
            'headers' => ['message']
        ]);
    }

    /**
     * POST api/transporter/$transporterUser/users
     *
     * @test
     * @return void
     */
    public function if_transporterUser_EPRALicence_not_provided_returns_unprocessable()
    {
        $transporterUser = TransporterUser::factory()->make();
        $newTransporterUser = User::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create transporter user');
        $response = $this->actingAs($user, 'api')
            ->postJson("/api/transporters/{$transporterUser->transporter->id}/users", [
                'transporterUserName' => $newTransporterUser->name,
                'transporterUserCode' => $newTransporterUser->code,
                'transporterUserLocation' => $newTransporterUser->location,
            ]);
        $response->assertUnprocessable();
    }

    /**
     * GET api/transporter/$transporterUser/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_transporterUsers()
    {
        $transporterUser = TransporterUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/transporters/{$transporterUser->transporter->id}/users");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [['id']]]);
        $response->assertJsonFragment(['id' => $transporterUser->id]);
    }

    /**
     * GET api/transporter/$transporterUser/users/:transporterUser
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_transporterUser()
    {
        $transporterUser = TransporterUser::factory()->create();
        $user = User::find($transporterUser->user_id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/transporters/{$transporterUser->transporter->id}/users/{$transporterUser->user_id}");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'firstName',
            'lastName',
            'username',
            'email',
            'phone'
        ]]);
        $response->assertJsonFragment(['transporterUserId' => $transporterUser->id]);
    }

    /**
     * PATCH api/transporter/$transporterUser/users
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_edit_their_transporterUser_registration_details()
    {
        $transporterUser = TransporterUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('update transporter user');
        $userEdit = User::factory()->make();
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/transporters/{$transporterUser->transporter->id}/users/{$transporterUser->user->id}", [
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

        $this->assertTrue(TransporterUser::find($transporterUser->id)->user->first_name === "$userEdit->first_name", 'TransporterUser not updated after patch request');

    }

    /**
     * DELETE api/transporter/$transporterUser/users
     *
     * @test
     * @return void
     */
    public function users_with_permission_can_delete_transporterUser()
    {
        $transporterUser = TransporterUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('delete transporter user');
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/transporters/{$transporterUser->transporter->id}/users/{$transporterUser->user->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(TransporterUser::find($transporterUser->id) === null, 'TransporterUser not deleted after delete request');

    }

    /**
     * DELETE api/transporter/$transporterUser/users
     *
     * @test
     * @return void
     */
    public function users_without_permission_cannot_delete_transporterUser()
    {
        $transporterUser = TransporterUser::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/transporters/{$transporterUser->transporter->id}/users/{$transporterUser->user->id}");
        $response->assertForbidden();

    }
}
