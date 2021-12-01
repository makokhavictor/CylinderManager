<?php

namespace Tests\Feature;

use App\Models\Canister;
use App\Models\DepotUser;
use App\Models\User;
use Tests\TestCase;

class CanisterLogTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function depot_user_can_log_new_canister()
    {
        $canister = Canister::factory()->create();
        $user = User::find(DepotUser::factory()->create()->user_id);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-log', [
                'toDepotId' => $user->depotUser->depot->id,
                'canisterId' => $canister->id,
                'filled' => $this->faker->boolean
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['id', 'toDepotName', 'toDepotId', 'canisterQR', 'filled'],
            'headers' => ['message']
        ]);
    }
}
