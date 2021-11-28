<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DepotUser;
use Tests\TestCase;

class RegisterDealerUserTest extends TestCase
{

    /**
     * POST api/depot-users
     *
     * @test
     * @return void
     */
    public function new_user_can_register_as_dealer_user()
    {
        $depotUser = DepotUser::factory()->make();
        $response = $this->actingAs($depotUser->user, 'api')
            ->postJson("/api/dealer-users", []);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['dealerUserId'],
            'headers' => ['message']
        ]);
    }
}
