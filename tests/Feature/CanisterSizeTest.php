<?php

namespace Tests\Feature;

use App\Models\CanisterSize;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanisterSizeTest extends TestCase
{
    /**
     * GET /api/canister-sizes
     *
     * @group canister-sizes
     * @test
     * @return void
     */
    public function authenticated_users_can_get_canister_sizes()
    {
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->get('/api/canister-sizes');
        CanisterSize::factory()->create();
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [['canisterSizeId', 'canisterSizeName']]
        ]);
    }
}
