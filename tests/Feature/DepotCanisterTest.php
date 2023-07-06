<?php

namespace Tests\Feature;

use App\Models\Canister;
use App\Models\CanisterLogBatch;
use App\Models\Depot;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotCanisterTest extends TestCase
{
    /**
     * GET api/depots/{depotId}/canisters
     *
     * @group depot-canisters
     * @test
     * @return void
     */
    public function authenticated_user_can_get_depot_canisters()
    {
        $order = Order::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::factory()->create();
        $depot->receivedCanisterLogs()->create([
            'canister_id' => Canister::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'canister_log_batch_id' => CanisterLogBatch::factory()->create([
                'order_id' => $order->id
            ])->id,
            'order_id' => $order->id
        ]);
        $response = $this->actingAs($user, 'api')
            ->get("/api/depots/{$depot->id}/canisters?filled=true&available=true");

        $response->assertStatus(200);
    }
}
