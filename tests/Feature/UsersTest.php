<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * GET api/users
     * @test
     * @group users
     */

    public function authenticated_users_can_view_users()
    {
        $user = User::find(User::factory()->create()->id);
        User::factory()->count(4)->create();
        $response = $this->actingAs($user, 'api')->get('api/users');
        echo $response->content();
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [['id', 'firstName', 'lastName', 'username', 'email', 'phone']],
            'meta'
        ]);

    }

}
