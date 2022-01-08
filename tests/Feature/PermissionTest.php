<?php

namespace Tests\Feature;

use App\Models\Depot;
use App\Models\Transporter;
use App\Models\User;
use Tests\TestCase;

class PermissionTest extends TestCase
{

    /**
     * POST api/{station}/{station_id}/roles
     * @group permission
     * @test
     */
    public function auth_user_can_get_depot_roles()
    {
        $user = User::find(User::factory()->create()->id);
        $depot = Depot::factory()->create();
        $depot->assignDefaultUserRoles();
        $response = $this->actingAs($user, 'api')
            ->getJson("api/depots/{$depot->id}/roles");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                ['roleId', 'roleName', 'permissions' => [['permissionName', 'permissionId']]]
            ]
        ]);
    }

    /**
     * POST api/{station}/{station_id}/roles
     * @group permission
     * @test
     */
    public function auth_user_can_get_transporter_roles()
    {
        $user = User::find(User::factory()->create()->id);
        $transporter = Transporter::factory()->create();
        $transporter->assignDefaultUserRoles();
        $response = $this->actingAs($user, 'api')
            ->getJson("api/transporters/{$transporter->id}/roles");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                ['roleId', 'roleName', 'permissions' => [['permissionName', 'permissionId']]]
            ]
        ]);
    }
}
