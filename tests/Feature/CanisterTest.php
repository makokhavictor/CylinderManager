<?php

namespace Tests\Feature;

use App\Models\Canister;
use App\Models\Depot;
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
     * POST api/canisters
     * @group canister
     * @test
     */

    public function user_with_permission_can_create_canister()
    {
        $user = User::find(User::factory()->create()->id);
        $canister = Canister::factory()->make();
        $user->assignRole('Depot Admin User');
        $response = $this->actingAs($user, 'api')
            ->postJson("api/canisters", [
                'canisterSize' => $canister->size,
                'canisterCode' => $canister->code,
                'canisterManuf' => $canister->manuf,
                'canisterManufDate' => $canister->manuf_date,
                'canisterBrandId' => $canister->brand_id,
                'canisterRFID' => $canister->RFID,
                'canisterRecertification' => $canister->recertification,
            ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'canisterId',
                'canisterRecertification',
                'canisterManuf',
                'canisterBrandId',
                'canisterBrandName',
                'canisterRFID',
                'canisterSize'
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
        $canisters = Canister::factory()->count(2)->create();
        $response = $this->actingAs($this->user, 'api')
            ->getJson("api/canisters");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [[
                'canisterId',
                'canisterRecertification',
                'canisterManuf',
                'canisterBrandId',
                'canisterBrandName',
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
        $canister = Canister::factory()->create();
        $response = $this->actingAs($this->user, 'api')
            ->getJson("api/canisters/{$canister->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'canisterId',
                'canisterRecertification',
                'canisterManuf',
                'canisterBrandId',
                'canisterBrandName',
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
        $canister = Canister::factory()->create();
        $updateCanister = Canister::factory()->make();
        $this->user->givePermissionTo('update canister');
        $response = $this->actingAs($this->user, 'api')
            ->patchJson("api/canisters/{$canister->id}", [
                'canisterCode' => $updateCanister->code,
                'canisterManuf' => $updateCanister->manuf,
                'canisterManufDate' => $updateCanister->manuf_date,
                'canisterBrandId' => $updateCanister->brand_id,
                'canisterRFID' => $updateCanister->RFID,
                'canisterRecertification' => $updateCanister->recertification
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['canisterId', 'canisterRFID'],
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
        $canister = Canister::factory()->create();
        $this->user->givePermissionTo('delete canister');
        $response = $this->actingAs($this->user, 'api')
            ->deleteJson("api/canisters/{$canister->id}", []);
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => ['message']
        ]);
    }

}
