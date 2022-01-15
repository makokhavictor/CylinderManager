<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    /**
     * POST api/orders
     *
     * @test
     * @group orders
     * @return void
     */
    public function dealer_user_can_create_an_order()
    {
        $user = User::find(User::factory()->create()->id);

        $dealer = Dealer::find(Dealer::factory()->create()->id);
        $depot = Depot::find(Depot::factory()->create()->id);
        $depot->assignDefaultUserRoles();

        $user->assignRole('Dealer User');

        $user->permissibleRoles()->save(Role::where(['name' => 'Dealer User'])->first(),
            ['permissible_id' => $dealer->id, 'permissible_type' => Dealer::class]
        );

        $response = $this->actingAs($user, 'api')->postJson('/api/orders', [
            'fromDepotId' => $depot->id,
            'toDealerId' => $dealer->id
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['orderId', 'fromDepotId', 'fromDepotName', 'toDealerId', 'toDealerName'],
            'headers' => ['message']
        ]);
    }

    /**
     * POST api/orders
     *
     * @test
     * @group orders
     * @return void
     */
    public function dealer_user_can_only_create_their_order()
    {
        $user = User::find(User::factory()->create()->id);

        $dealer = Dealer::find(Dealer::factory()->create()->id);
        $depot = Depot::find(Depot::factory()->create()->id);
        $depot->assignDefaultUserRoles();

        $user->assignRole('Dealer User');

        $response = $this->actingAs($user, 'api')->postJson('/api/orders', [
            'fromDepotId' => $depot->id,
            'toDealerId' => $dealer->id
        ]);

        $response->assertForbidden();
    }
}
