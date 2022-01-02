<?php

namespace Tests\Feature;

use App\Models\CanisterLog;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use App\Models\User;
use Tests\TestCase;

class StatisticsTest extends TestCase
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

    /**
     * @test
     * @group statistics
     */
    public function auth_user_can_get_dealer_statistics()
    {
        $user = User::find(User::factory()->create()->id);
        $dealer = Dealer::factory()->create();
        CanisterLog::factory()->state([
            'to_dealer_id' => $dealer->id,
            'filled' => true
        ])->count(2)->create();
        CanisterLog::factory()->state([
            'to_dealer_id' => $dealer->id,
            'filled' => false
        ])->count(3)->create();
        CanisterLog::factory()->state([
            'to_dealer_id' => $dealer->id,
            'defective' => true
        ])->count(4)->create();
        $response = $this->actingAs($user, 'api')
            ->getJson("api/dealers/{$dealer->id}/statistics");
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

    /**
     * @test
     * @group statistics
     */
    public function auth_user_can_get_transporters_statistics()
    {
        $user = User::find(User::factory()->create()->id);
        $transporter = Transporter::factory()->create();
        CanisterLog::factory()->state([
            'to_transporter_id' => $transporter->id,
            'filled' => true
        ])->count(2)->create();
        CanisterLog::factory()->state([
            'to_transporter_id' => $transporter->id,
            'filled' => false
        ])->count(3)->create();
        CanisterLog::factory()->state([
            'to_transporter_id' => $transporter->id,
            'defective' => true
        ])->count(4)->create();
        $response = $this->actingAs($user, 'api')
            ->getJson("api/transporters/{$transporter->id}/statistics");
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
