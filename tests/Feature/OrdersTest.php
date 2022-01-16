<?php

namespace Tests\Feature;

use App\Models\CanisterSize;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Order;
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
            'toDealerId' => $dealer->id,
            'orderQuantities' => [[
                'canisterSizeId' => CanisterSize::factory()->create()->id, 'quantity' => 5],
                ['canisterSizeId' => CanisterSize::factory()->create()->id, 'quantity' => 4]]
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'orderId',
                'fromDepotId',
                'fromDepotName',
                'toDealerId',
                'toDealerName',
                'orderQuantities' => [['canisterSizeId', 'canisterSizeName', 'quantity']]
            ],
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
            'toDealerId' => $dealer->id,
            'orderQuantities' => [[
                'canisterSizeId' => CanisterSize::factory()->create()->id, 'quantity' => 2],
                ['canisterSizeId' => CanisterSize::factory()->create()->id, 'quantity' => 3]]
        ]);

        $response->assertForbidden();
    }

    /**
     * GET api/orders
     *
     * @test
     * @group orders
     * @return void
     */

    public function authenticated_user_can_retrieve_orders()
    {
        $user = User::find(User::factory()->create()->id);
        $orders = Order::factory()->count(2)->create();
        foreach ($orders as $order) {
            $order->canisterSizes()->save(CanisterSize::factory()->create());
        }

        $response = $this->actingAs($user, 'api')->getJson('/api/orders');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [['orderId', 'orderQuantities' => [['canisterSizeId', 'canisterSizeName', 'value', 'quantity']]]]
        ]);
    }

    /**
     * DELETE api/orders
     *
     * @test
     * @group orders
     * @return void
     */

    public function authorized_user_can_delete_orders()
    {
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('delete refill order');
        $order = Order::factory()->create();
        $order->canisterSizes()->save(CanisterSize::factory()->create());

        $response = $this->actingAs($user, 'api')->deleteJson("/api/orders/{$order->id}");

        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => ['message']
        ]);
    }
}
