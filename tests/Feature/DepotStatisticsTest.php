<?php

namespace Tests\Feature;

use App\Models\CanisterLog;
use App\Models\Depot;
use App\Models\User;
use Tests\TestCase;

class DepotStatisticsTest extends TestCase
{
    /**
     * @test
     * @group statistics
     */
    public function auth_user_can_get_depot_statistics()
    {
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::factory()->create();
        CanisterLog::factory()->state([
            'to_depot_id' => $depot->id,
            'filled' => true
        ])->count(2)->create();
        CanisterLog::factory()->state([
            'to_depot_id' => $depot->id,
            'filled' => false
        ])->count(3)->create();
        CanisterLog::factory()->state([
            'to_depot_id' => $depot->id,
            'defective' => true
        ])->count(4)->create();
        $response = $this->actingAs($user, 'api')
            ->getJson("api/depots/{$depot->id}/statistics");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'canisters' => ['filled', 'empty', 'defective']
            ]
        ]);
        $response->assertJsonFragment(['filled' => 2]);
        $response->assertJsonFragment(['empty' => 3]);
        $response->assertJsonFragment(['defective' => 4]);
    }


}
