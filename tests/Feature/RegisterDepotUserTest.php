<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DepotUser;
use Tests\TestCase;

class RegisterDepotUserTest extends TestCase
{

    /**
     * POST api/depot-users
     *
     * @test
     * @return void
     */
    public function new_user_can_register_as_depot_user()
    {
        $depotUser = DepotUser::factory()->make();
        $response = $this->actingAs($depotUser->user, 'api')
            ->postJson("/api/depot-users", []);
        $response->assertCreated();
        $response->assertSee('Depot Admin');
        $response->assertSee('create depot user');
        $response->assertJsonStructure([
            'data' => ['depotUserId'],
            'headers' => ['message']
        ]);
    }
}
