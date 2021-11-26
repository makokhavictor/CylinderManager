<?php

namespace Tests\Feature;

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
    public function authenticated_user_can_register_as_a_dealer()
    {
        $dealer = Dealer::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/dealers', [
                'dealerCode' => $dealer->code,
                'dealerEPRALicence' => $dealer->EPRA_licence,
                'dealerLocation' => $dealer->location,
                'dealerGPS' => $dealer->GPS,
            ]);
        echo json_encode([
            'dealerCode' => $dealer->code,
            'dealerEPRALicence' => $dealer->EPRA_licence,
            'dealerLocation' => $dealer->location,
            'dealerGPS' => $dealer->GPS,
        ]);
        $response->assertCreated();
    }

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
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/dealers', [
                'dealerCode' => $dealer->code,
                'dealerLocation' => $dealer->EPRA_License,
                'dealerGPS' => $dealer->gps,
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
            'dealerEPRALicense',
            'dealerLocation',
            'dealerGPS',
        ]]]);
        $response->assertJsonFragment(['id' => $dealer->id]);
        $response->assertJsonFragment(['dealerCode' => $dealer->code]);
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
            'dealerEPRALicense',
            'dealerLocation',
            'dealerGPS',
        ]]);
        $response->assertJsonFragment(['id' => $dealer->id]);
        $response->assertJsonFragment(['dealerCode' => $dealer->code]);
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
                'code' => $dealerEdit->code,
                'dealerEPRALicense' => $dealerEdit->EPRA_License,
                'dealerLocation' => $dealerEdit->EPRA_License,
                'dealerGPS' => $dealerEdit->gps,
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'dealerCode',
                'dealerEPRALicense',
                'dealerLocation',
                'dealerGPS',
            ],
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(Dealer::find($dealer->id)->code === $dealerEdit->code, 'Dealer not updated after patch request');

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
        $this->assertTrue(Dealer::find($dealer->id)->code === null, 'Dealer not deleted after delete request');

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
