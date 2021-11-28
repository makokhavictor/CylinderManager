<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Depot;
use Tests\TestCase;

class DepotTest extends TestCase
{
    /**
     * POST api/depots
     *
     * @test
     * @return void
     */
    public function authenticated_user_with_permission_can_create_depot()
    {
        $depot = Depot::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create depot');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/depots', [
                'depotName' => $depot->name,
                'depotCode' => $depot->code,
                'depotEPRALicenceNo' => $depot->EPRA_licence_no,
                'depotLocation' => $depot->location,
            ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'depotName'],
            'headers' => ['message']
        ]);
    }

    /**
     * POST api/depots
     *
     * @test
     * @return void
     */
    public function if_depot_EPRALicence_not_provided_returns_unprocessable()
    {
        $depot = Depot::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/depots', [
                'depotName' => $depot->name,
                'depotCode' => $depot->code,
                'depotLocation' => $depot->location,
            ]);
        $response->assertUnprocessable();
    }

    /**
     * GET api/depots
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_depots()
    {
        $depot = Depot::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson('/api/depots');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [[
            'id',
            'depotCode',
            'depotName',
            'depotEPRALicenceNo',
            'depotLocation',
        ]]]);
        $response->assertJsonFragment(['id' => $depot->id]);
    }

    /**
     * GET api/depots/:depot
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_depot()
    {
        $depot = Depot::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/depots/$depot->id");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'depotCode',
            'depotName',
            'depotEPRALicenceNo',
            'depotLocation',
        ]]);
        $response->assertJsonFragment(['id' => $depot->id]);
        $response->assertJsonFragment(['depotName' => $depot->name]);
    }

    /**
     * PATCH api/depots
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_edit_their_depot_registration_details()
    {
        $depotEdit = Depot::factory()->make();
        $depot = Depot::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/depots/$depot->id", [
                'depotCode' => $depotEdit->code,
                'depotName' => $depotEdit->name,
                'depotEPRALicenceNo' => $depotEdit->EPRA_licence_no,
                'depotLocation' => $depotEdit->location,
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'depotCode',
                'depotEPRALicenceNo',
                'depotLocation',
                'depotName'
            ],
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(Depot::find($depot->id)->code === "$depotEdit->code", 'Depot not updated after patch request');

    }

    /**
     * DELETE api/depots
     *
     * @test
     * @return void
     */
    public function users_with_permission_can_delete_depot()
    {
        $depot = Depot::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('delete depot');
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/depots/$depot->id");
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(Depot::find($depot->id) === null, 'Depot not deleted after delete request');

    }

    /**
     * DELETE api/depots
     *
     * @test
     * @return void
     */
    public function users_without_permission_cannot_delete_depot()
    {
        $depot = Depot::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/depots/$depot->id");
        $response->assertForbidden();

    }
}
