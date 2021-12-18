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
        $user = User::find(DepotUser::factory()->create()->user_id);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-logs', [
                'toDepotId' => $user->depotUser->depot->id,
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
        $user = User::find(DepotUser::factory()->create()->user_id);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/canister-logs', [
                'toDepotId' => $user->depotUser->depot->id,
            ]);
        $response->assertUnprocessable();
    }
}
