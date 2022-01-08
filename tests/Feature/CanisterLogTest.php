<?php

namespace Tests\Feature;

use App\Models\Canister;
use App\Models\CanisterLog;
use App\Models\Depot;
use App\Models\Role;
use App\Models\Transporter;
use App\Models\User;
use Tests\TestCase;

class CanisterLogTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     * @group canister-logs
     * @return void
     */
    public function depot_user_can_log_new_canisters()
    {
        $canisters = Canister::factory()
            ->count(3)
            ->create()
            ->map
            ->only(['id', 'filled'])
            ->map(function ($item) {
                $item['filled'] = $this->faker->boolean;
                return $item;
            });
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::find(Depot::factory()->create()->id);
        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-logs', [
                'toDepotId' => $user->depots[0]->id,
                'canisters' => $canisters->toArray(),
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'batchId', 'canisters' => [[
                    'id', 'canisterQR', 'brandId', 'brandName', 'filled', 'toDepotName', 'toDepotId',
                ]]
            ],
            'headers' => ['message']
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @group canister-logs
     * @return void
     */
    public function canisters_field_is_required_as_array()
    {
        Canister::factory()
            ->count(3)
            ->create()
            ->map
            ->only(['id', 'filled'])
            ->map(function ($item) {
                $item['filled'] = $this->faker->boolean;
                return $item;
            });
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::find(Depot::factory()->create()->id);
        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-logs', [
                'toDepotId' => $user->depots[0]->id,
            ]);
        $response->assertUnprocessable();
    }

    /**
     * @test
     * @group canister-logs
     */

    public function canister_should_be_marked_as_released_from_depot_when_new_log_is_added()
    {
        $canisters = Canister::factory()
            ->count(3)
            ->create()
            ->map
            ->only(['id', 'filled'])
            ->map(function ($item) {
                $item['filled'] = $this->faker->boolean;
                return $item;
            });
        $user = User::find(User::factory()->create()->id);
        $currentDepot = Depot::factory()->create();
        $user->assignRole('Depot User');

        $canisterLog = CanisterLog::factory()->state([
            'canister_id' => $canisters[0]['id'],
            'user_id' => $user->id,
            'to_depot_id' => $currentDepot->id
        ])->create();

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-logs', [
                'toDepotId' => Depot::factory()->create()->id,
                'canisters' => $canisters->toArray(),
            ]);
        $response->assertOk();

        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_at,'Released at field not updated after canister log creation');
        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_to_depot_id, 'Released to depot id field not updated after canister log creation');
    }

    /**
     * @test
     * @group canister-logs
     */

    public function canister_should_be_marked_as_released_from_transporter_when_new_log_is_added()
    {
        $canisters = Canister::factory()
            ->count(3)
            ->create()
            ->map
            ->only(['id', 'filled'])
            ->map(function ($item) {
                $item['filled'] = $this->faker->boolean;
                return $item;
            });
        $user = User::find(User::factory()->create()->id);
        $user->assignRole('Depot User');

        $currentDepot = Depot::factory()->create();

        $canisterLog = CanisterLog::factory()->state([
            'canister_id' => $canisters[0]['id'],
            'user_id' => $user->id,
            'to_depot_id' => $currentDepot->id
        ])->create();

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-logs', [
                'toTransporterId' => Transporter::factory()->create()->id,
                'canisters' => $canisters->toArray(),
            ]);
        $response->assertOk();

        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_at,'Released at field not updated after canister log creation');
        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_to_transporter_id, 'Released to transporter id field not updated after canister log creation');
    }
}
