<?php

namespace Tests\Feature;

use App\Models\DealerUser;
use App\Models\User;
use App\Models\Dealer;
use Tests\TestCase;

class DealerTest extends TestCase
{
    /**
     * POST api/dealers
     *
     * @test
     * @return void
     */
    public function authenticated_user_with_permission_can_create_dealer()
    {
        $dealer = Dealer::factory()->make();
        $user = User::find(User::factory()->create()->id);
        DealerUser::factory()
            ->state(['dealer_id' => null, 'user_id' => $user->id])
            ->create();
        $user->givePermissionTo('create dealer');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/dealers', [
                'dealerName' => $dealer->name,
                'dealerCode' => $dealer->code,
                'dealerEPRALicenceNo' => $dealer->EPRA_licence_no,
                'dealerLocation' => $dealer->location,
                'dealerGPS' => $dealer->GPS,
            ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'dealerName'],
            'headers' => ['message']
        ]);
    }

//    /**
//     * POST api/dealers
//     *
//     * @test
//     * @return void
//     */
//    public function users_not_registered_as_dealer_cannot_create_dealer()
//    {
//        $dealer = Dealer::factory()->make();
//        $user = User::find(User::factory()->create()->id);
//        $user->givePermissionTo('create dealer');
//        $response = $this->actingAs($user, 'api')
//            ->postJson('/api/dealers', [
//                'dealerName' => $dealer->name,
//                'dealerCode' => $dealer->code,
//                'dealerEPRALicenceNo' => $dealer->EPRA_licence_no,
//                'dealerLocation' => $dealer->location,
//                'dealerGPS' => $dealer->GPS,
//            ]);
//        $response->assertUnprocessable();
//    }

    /**
     * POST api/dealers
     *
     * @test
     * @return void
     */
    public function if_dealer_EPRALicence_not_provided_returns_unprocessable()
    {
        $dealer = Dealer::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create dealer');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/dealers', [
                'dealerName' => $dealer->name,
                'dealerCode' => $dealer->code,
                'dealerLocation' => $dealer->location,
            ]);
        $response->assertUnprocessable();
    }

    /**
     * GET api/dealers
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_dealers()
    {
        $dealer = Dealer::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson('/api/dealers');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [[
            'id',
            'dealerCode',
            'dealerName',
            'dealerEPRALicenceNo',
            'dealerLocation',
        ]]]);
        $response->assertJsonFragment(['id' => $dealer->id]);
    }

    /**
     * GET api/dealers/:dealer
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_dealer()
    {
        $dealer = Dealer::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/dealers/$dealer->id");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'dealerCode',
            'dealerName',
            'dealerEPRALicenceNo',
            'dealerLocation',
        ]]);
        $response->assertJsonFragment(['id' => $dealer->id]);
        $response->assertJsonFragment(['dealerName' => $dealer->name]);
    }

    /**
     * PATCH api/dealers
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_edit_their_dealer_registration_details()
    {
        $dealerEdit = Dealer::factory()->make();
        $dealer = Dealer::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/dealers/$dealer->id", [
                'dealerCode' => $dealerEdit->code,
                'dealerName' => $dealerEdit->name,
                'dealerEPRALicenceNo' => $dealerEdit->EPRA_licence_no,
                'dealerLocation' => $dealerEdit->location,
                'dealerGPS' => $dealerEdit->GPS,
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'dealerCode',
                'dealerEPRALicenceNo',
                'dealerLocation',
                'dealerName'
            ],
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(Dealer::find($dealer->id)->code === "$dealerEdit->code", 'Dealer not updated after patch request');

    }

    /**
     * DELETE api/dealers
     *
     * @test
     * @return void
     */
    public function users_with_permission_can_delete_dealer()
    {
        $dealer = Dealer::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('delete dealer');
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/dealers/$dealer->id");
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(Dealer::find($dealer->id) === null, 'Dealer not deleted after delete request');

    }

    /**
     * DELETE api/dealers
     *
     * @test
     * @return void
     */
    public function users_without_permission_cannot_delete_dealer()
    {
        $dealer = Dealer::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/dealers/$dealer->id");
        $response->assertForbidden();

    }
}
