<?php

namespace Tests\Feature;

use App\Models\Canister;
use App\Models\CanisterSize;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderDispatchTest extends TestCase
{
    /**
     * POST orders/:order/dispatch
     *
     * @group dispatch test
     * @test
     * @return void
     */
    public function depot_users_can_dispatch_filled_canisters_to_dealers()
    {
        $canisterSizes = CanisterSize::factory()->count(2)->create();
        $order = Order::factory()->create();
//        $canisterIds = '';
        foreach ($canisterSizes as $canisterSize) {
            $order->canisterSizes()->save($canisterSize, ['quantity' => 2]);
        }

        $response = $this->post("/api/orders/{$order->id}/dispatch");

        $response->assertOk();
    }
}
