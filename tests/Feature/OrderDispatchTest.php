<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Canister;
use App\Models\CanisterSize;
use App\Models\Order;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderDispatchTest extends TestCase
{
    /**
     * POST orders/:order/dispatch
     *
     * @group dispatch
     * @test
     * @return void
     */

    public function depot_users_can_dispatch_filled_canisters_to_dealers()
    {
        $canisterSizes = CanisterSize::factory()->count(2)->create();
        $order = Order::factory()
            ->state(['assigned_to' => Transporter::factory()->create()->id])
            ->create();
        $brand = Brand::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('dispatch canister');
        $canisters = [];
        foreach ($canisterSizes as $canisterSize) {
            $canisters[] = [
                'canisterId' => Canister::factory()->state(['canister_size_id' => $canisterSize->id])->create()->id
            ];
            $order->canisterSizes()->save($canisterSize, ['quantity' => 2, 'brand_id' => $brand->id]);
        }

        $response = $this->actingAs($user, 'api')
            ->postJson("/api/orders/{$order->id}/dispatch", [
                'canisters' => $canisters
            ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'canisters' => [
                    ['canisterId', 'canisterBrandName']
                ]
            ],
            'headers' => ['message']
        ]);
    }
}
