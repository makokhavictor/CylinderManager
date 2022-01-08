<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PermissionTest extends TestCase
{

    /**
     * POST api/permissions/stations
     * @group permission
     * @test
     */
    public function auth_user_can_get_station_roles()
    {
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson('api/permissions/stations');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'depots' => [],
                'transporters' => [],
                'dealers' => [],
            ]
        ]);

    }
}
