<?php

namespace Tests\Feature;

use App\Models\Canister;
use App\Models\Depot;
use App\Models\DepotUser;
use App\Models\User;
use Tests\TestCase;

class CanisterTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(User::factory()->create()->id);
    }

    /**
     * POST api/depot/{depotId}/canisters
     * @group canister
     * @test
     */

    public function user_with_permission_can_create_canister()
    {
        $depotUser = DepotUser::factory()->create();
        $user = User::find($depotUser->user_id);
        $canister = Canister::factory()->make();
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson("api/depots/{$depotUser->depot_id}/canisters", [
                'canisterCode' => $canister->code,
                'canisterManuf' => $canister->manuf,
                'canisterManufDate' => $canister->manuf_date,
                'brandId' => $canister->brand_id,
                'canisterRFID' => $canister->RFID,
                'canisterQR' => $canister->QR,
                'canisterRecertification' => $canister->recertification
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'canisterRecertification',
                'canisterManuf',
                'brandId',
                'brandName',
                'canisterQR',
                'canisterRFID'
            ],
            'headers' => ['message']
        ]);
    }

    /**
     * GET api/depot/{depotId}/canisters
     * @group canister
     * @test
     */

    public function authenticated_users_can_get_canisters()
    {
        $depotId = Depot::factory()->create()->id;
        $canisters = Canister::factory()->count(2)->create();
        $response = $this->actingAs($this->user, 'api')
            ->getJson("api/depots/{$depotId}/canisters");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'canisterRecertification',
                'canisterManuf',
                'brandId',
                'brandName',
                'canisterQR',
                'canisterRFID']
            ]
        ]);
        $response->assertJsonFragment(['canisterRFID' =>"{$canisters[0]->RFID}"]);
    }


    /**
     * GET api/depot/{depotId}/canisters
     * @group canister
     * @test
     */

    public function authenticated_users_can_get_canister()
    {
        $depotId = Depot::factory()->create()->id;
        $canister = Canister::factory()->create();
        $response = $this->actingAs($this->user, 'api')
            ->getJson("api/depots/{$depotId}/canisters/{$canister->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'canisterRecertification',
                'canisterManuf',
                'brandId',
                'brandName',
                'canisterQR',
                'canisterRFID'
            ]
        ]);
        $response->assertJsonFragment(['canisterRFID' => "{$canister->RFID}"]);
    }


    /**
     * PATCH api/depot/{depotId}/canisters
     * @group canister
     * @test
     */

    public function user_with_permission_can_update_canister()
    {
        $depotId = Depot::factory()->create()->id;
        $canister = Canister::factory()->create();
        $updateCanister = Canister::factory()->make();
        $this->user->givePermissionTo('update canister');
        $response = $this->actingAs($this->user, 'api')
            ->patchJson("api/depots/{$depotId}/canisters/{$canister->id}", [
                'canisterCode' => $updateCanister->code,
                'canisterManuf' => $updateCanister->manuf,
                'canisterManufDate' => $updateCanister->manuf_date,
                'brandId' => $updateCanister->brand_id,
                'canisterRFID' => $updateCanister->RFID,
                'canisterQR' => $updateCanister->QR,
                'canisterRecertification' => $updateCanister->recertification
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['id', 'canisterRFID'],
            'headers' => ['message']
        ]);
        $response->assertJsonFragment(['canisterRFID' => $updateCanister->RFID]);
    }

    /**
     * PATCH api/depot/{depotId}/canisters
     * @group canister
     * @test
     */

    public function user_with_permission_can_delete_canister()
    {
        $depotId = Depot::factory()->create()->id;
        $canister = Canister::factory()->create();
        $this->user->givePermissionTo('update canister');
        $response = $this->actingAs($this->user, 'api')
            ->deleteJson("api/depots/{$depotId}/canisters/{$canister->id}", []);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [],
            'headers' => ['message']
        ]);
    }

}
