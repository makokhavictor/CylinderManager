<?php

namespace Tests\Feature;

use App\Events\CanisterLogCreatedEvent;
use App\Models\Canister;
use App\Models\CanisterLog;
use App\Models\CanisterLogBatch;
use App\Models\Dealer;
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
    public function depot_user_can_dispatch_to_dealer()
    {
        $canisters = Canister::factory()
            ->count(3)
            ->create()
            ->map
            ->only(['id', 'filled'])
            ->map(function ($item) {
                $item['canisterId'] = $item['id'];
                $item['filled'] = $this->faker->boolean;
                return $item;
            });
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::find(Depot::factory()->create()->id);
        $dealer = Dealer::find(Dealer::factory()->create()->id);
        $transporter = Transporter::find(Transporter::factory()->create()->id);
        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canisters/batch-dispatches', [
                'fromDepotId' => $depot->id,
                'toDealerId' => $dealer->id,
                'transporterId' => $transporter->id,
                'canisters' => $canisters->toArray(),
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'canisterBatchId', 'fromDepotName', 'fromDepotId', 'toDealerName', 'toDealerId', 'canisters' => [[
                    'canisterId', 'canisterQR', 'brandId', 'brandName', 'filled',
                ]]
            ],
            'headers' => ['message']
        ]);
    }


    /**
     * A basic feature test example.
     *
     * @test
     * @group canister-logs-1
     * @return void
     */
    public function transporter_user_can_receive_from_depot()
    {
        $canisters = Canister::factory()
            ->count(3)
            ->create()
            ->map
            ->only(['id', 'filled'])
            ->map(function ($item) {
                $item['canisterId'] = $item['id'];
                $item['filled'] = $this->faker->boolean;
                return $item;
            });
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::find(Depot::factory()->create()->id);
        $dealer = Dealer::find(Dealer::factory()->create()->id);
        $transporter = Transporter::find(Transporter::factory()->create()->id);
        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
        $user->assignRole('Transporter User');

        $batch = CanisterLogBatch::create([
            'toable_id' =>  $dealer->id,
            'toable_type' => Dealer::class,
            'fromable_id' => $depot->id,
            'fromable_type' => Depot::class,
            'transporter_id' => $transporter->id
        ]);

        foreach ($canisters as $canister) {
            $batch->canisterLogs()->create([
                'toable_id' => $batch->toable_id,
                'toable_type' => $batch->toable_type,
                'fromable_id' => $batch->fromable_id,
                'fromable_type' => $batch->fromable_type,
                'canister_id' => $canister['id'],
                'filled' => $canister['filled'],
                'user_id' => User::factory()->create()->id
            ]);
        }

        $response = $this->actingAs($user, 'api')
            ->getJson("/api/canisters/batch-dispatches?received=false&transporterId={$transporter->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [[
                'canisterBatchId', 'canisterBatchReceived', 'fromDepotName', 'fromDepotId', 'toDealerName', 'toDealerId', 'canisters' => [[
                    'canisterId', 'canisterQR', 'brandId', 'brandName', 'filled',
                ]]]
            ],
        ]);
    }

//    /**
//     * A basic feature test example.
//     *
//     * @test
//     * @group canister-logs
//     * @return void
//     */
//    public function depot_user_can_di_from_depot()
//    {
//        $canisters = Canister::factory()
//            ->count(3)
//            ->create()
//            ->map
//            ->only(['id', 'filled'])
//            ->map(function ($item) {
//                $item['canisterId'] = $item['id'];
//                $item['filled'] = $this->faker->boolean;
//                return $item;
//            });
//        $user = User::find(User::factory()->create()->id);
//        $depot = Depot::find(Depot::factory()->create()->id);
//        $dealer = Dealer::find(Dealer::factory()->create()->id);
//        $transporter = Transporter::find(Transporter::factory()->create()->id);
//        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
//        $user->assignRole('Transporter User');
//
//        $batch = CanisterLogBatch::create([
//            'toable_id' =>  $dealer->id,
//            'toable_type' => Dealer::class,
//            'fromable_id' => $depot->id,
//            'fromable_type' => Depot::class,
//            'transporter_id' => $transporter->id
//        ]);
//
//        foreach ($canisters as $canister) {
//            $batch->canisterLogs()->create([
//                'toable_id' => $batch->toable_id,
//                'toable_type' => $batch->toable_type,
//                'fromable_id' => $batch->fromable_id,
//                'fromable_type' => $batch->fromable_type,
//                'canister_id' => $canister['id'],
//                'filled' => $canister['filled'],
//                'user_id' => User::factory()->create()->id
//            ]);
//        }
//
//        $response = $this->actingAs($user, 'api')
//            ->postJson('/api/canisters/batch-dispatches', [
//                'fromDepotId' => $depot->id,
//                'toDealerId' => $dealer->id,
//                'transporterId' => $transporter->id,
//                'canisters' => $canisters->toArray(),
//            ]);
//        $response->assertOk();
//        $response->assertJsonStructure([
//            'data' => [
//                'canisterBatchId', 'fromDepotName', 'fromDepotId', 'toDealerName', 'toDealerId', 'canisters' => [[
//                    'canisterId', 'canisterQR', 'brandId', 'brandName', 'filled',
//                ]]
//            ],
//            'headers' => ['message']
//        ]);
//    }

    /**
     * A basic feature test example.
     *
     * @test
     * @group canister-logs
     * @return void
     */
    public function dealer_user_can_dispatch_to_depot()
    {
        $canisters = Canister::factory()
            ->count(3)
            ->create()
            ->map
            ->only(['id', 'filled'])
            ->map(function ($item) {
                $item['canisterId'] = $item['id'];
                $item['filled'] = $this->faker->boolean;
                return $item;
            });
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::find(Depot::factory()->create()->id);
        $dealer = Dealer::find(Dealer::factory()->create()->id);
        $transporter = Transporter::find(Transporter::factory()->create()->id);
        $dealer->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Dealer User')->first()->id ]);
        $user->assignRole('Dealer User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canisters/batch-dispatches', [
                'fromDealerId' => $dealer->id,
                'toDepotId' => $depot->id,
                'transporterId' => $transporter->id,
                'canisters' => $canisters->toArray(),
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'canisterBatchId', 'fromDealerName', 'fromDealerId', 'toDepotName', 'toDepotId', 'canisters' => [[
                    'canisterId', 'canisterQR', 'brandId', 'brandName', 'filled',
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
        $dealer = Dealer::find(Dealer::factory()->create()->id);
        $transporter = Transporter::find(Transporter::factory()->create()->id);
        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-logs', [
                'fromDepotId' => $depot->id,
                'toDealerId' => $dealer->id,
                'transporterId' => $transporter->id,
            ]);
        $response->assertUnprocessable();
    }

//    /**
//     * @test
//     * @group canister-logs
//     */
//
//    public function canister_should_be_marked_as_released_from_depot_when_new_log_is_added()
//    {
//        $canisters = Canister::factory()
//            ->count(3)
//            ->create()
//            ->map
//            ->only(['id', 'filled'])
//            ->map(function ($item) {
//                $item['filled'] = $this->faker->boolean;
//                return $item;
//            });
//        $user = User::find(User::factory()->create()->id);
//        $currentDepot = Depot::factory()->create();
//        $user->assignRole('Depot User');
//
//        $canisterLog = CanisterLog::factory()->state([
//            'canister_id' => $canisters[0]['id'],
//            'user_id' => $user->id,
//            'to_depot_id' => $currentDepot->id
//        ])->create();
//
//        $response = $this->actingAs($user, 'api')
//            ->postJson('/api/canister-logs', [
//                'toDepotId' => Depot::factory()->create()->id,
//                'canisters' => $canisters->toArray(),
//            ]);
//        $response->assertOk();
//
//        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_at,'Released at field not updated after canister log creation');
//        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_to_depot_id, 'Released to depot id field not updated after canister log creation');
//    }
//
//    /**
//     * @test
//     * @group canister-logs
//     */
//
//    public function canister_should_be_marked_as_released_from_transporter_when_new_log_is_added()
//    {
//        $canisters = Canister::factory()
//            ->count(3)
//            ->create()
//            ->map
//            ->only(['id', 'filled'])
//            ->map(function ($item) {
//                $item['filled'] = $this->faker->boolean;
//                return $item;
//            });
//        $user = User::find(User::factory()->create()->id);
//        $user->assignRole('Depot User');
//
//        $currentDepot = Depot::factory()->create();
//
//        $canisterLog = CanisterLog::factory()->state([
//            'canister_id' => $canisters[0]['id'],
//            'user_id' => $user->id,
//            'to_depot_id' => $currentDepot->id
//        ])->create();
//
//        $response = $this->actingAs($user, 'api')
//            ->postJson('/api/canister-logs', [
//                'toTransporterId' => Transporter::factory()->create()->id,
//                'canisters' => $canisters->toArray(),
//            ]);
//        $response->assertOk();
//
//        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_at,'Released at field not updated after canister log creation');
//        $this->assertNotNull(CanisterLog::find($canisterLog->id)->released_to_transporter_id, 'Released to transporter id field not updated after canister log creation');
//    }
}
