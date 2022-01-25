<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    /**
     * POST /api/orders/{orderId}/status
     *
     * @group order-status
     * @test
     * @return void
     */
    public function admin_can_assign_an_order()
    {
        $user = User::find(User::factory()->create()->id);
        $user->assignRole('Admin');
        $transporter = Transporter::factory()->create();
        $order = Order::factory()->create();
        $response = $this->actingAs($user, 'api')->postJson("/api/orders/{$order->id}/status", [
            'transporterId' => $transporter->id
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'orderId', 'assignedToTransporterId', 'assignedToTransporterName', 'isAssigned', 'assignedAt'
            ],
            'headers' => ['message']
        ]);

        $response->assertJsonFragment(['isAssigned' => true]);
    }

    /**
     * POST /api/orders/{orderId}/status
     *
     * @group order-status
     * @test
     * @return void
     */
    public function admin_can_acknowledge_order()
    {
        $user = User::find(User::factory()->create()->id);
        $user->assignRole('Admin');
        $order = Order::factory()->create();
        $response = $this->actingAs($user, 'api')->postJson("/api/orders/{$order->id}/status", [
            'acceptOrder' => true
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'orderId', 'assignedToTransporterId', 'assignedToTransporterName', 'isAssigned', 'assignedAt'
            ],
            'headers' => ['message']
        ]);

        $response->assertJsonFragment(['isAccepted' => true]);
    }

    /**
     * POST /api/orders/{orderId}/status
     *
     * @group order-status
     * @test
     * @return void
     */
    public function admin_can_confirm_transporter_to_depot_order()
    {
        $user = User::find(User::factory()->create()->id);
        $user->assignRole('Admin');
        $order = Order::factory()->create();
        $response = $this->actingAs($user, 'api')->postJson("/api/orders/{$order->id}/status", [
            'depotToTransporterOk' => true
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'orderId',
                'assignedToTransporterId',
                'assignedToTransporterName',
                'isAssigned',
                'assignedAt',
                'depotToTransporterConfirmed',
                'depotToTransporterConfirmedAt'
            ],
            'headers' => ['message']
        ]);

        $response->assertJsonFragment(['depotToTransporterConfirmed' => true]);
    }
}
