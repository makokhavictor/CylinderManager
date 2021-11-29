<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DepotUser;
use Tests\TestCase;

class RegisterTransporterUserTest extends TestCase
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
            ->postJson("/api/transporter-users", []);
        $response->assertSee('Transporter Admin');
        $response->assertSee('create transporter user');
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['transporterUserId'],
            'headers' => ['message']
        ]);
    }
}
