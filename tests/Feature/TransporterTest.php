<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transporter;
use Tests\TestCase;

class TransporterTest extends TestCase
{
    /**
     * POST api/transporters
     *
     * @test
     * @return void
     */
    public function authenticated_user_with_permission_can_create_transporter()
    {
        $transporter = Transporter::factory()->make();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('create transporter');
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/transporters', [
                'transporterName' => $transporter->name,
                'transporterCode' => $transporter->code,
            ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['id', 'transporterName'],
            'headers' => ['message']
        ]);
    }

    /**
     * GET api/transporters
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_transporters()
    {
        $transporter = Transporter::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson('/api/transporters');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [[
            'id',
            'transporterCode',
            'transporterName',
        ]]]);
        $response->assertJsonFragment(['id' => $transporter->id]);
    }

    /**
     * GET api/transporters/:transporter
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_get_transporter()
    {
        $transporter = Transporter::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/transporters/$transporter->id");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            'id',
            'transporterCode',
            'transporterName',
        ]]);
        $response->assertJsonFragment(['id' => $transporter->id]);
        $response->assertJsonFragment(['transporterName' => $transporter->name]);
    }

    /**
     * PATCH api/transporters
     *
     * @test
     * @return void
     */
    public function authenticated_user_can_edit_their_transporter_registration_details()
    {
        $transporterEdit = Transporter::factory()->make();
        $transporter = Transporter::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/transporters/$transporter->id", [
                'transporterCode' => $transporterEdit->code,
                'transporterName' => $transporterEdit->name,
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'transporterCode',
                'transporterName'
            ],
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(Transporter::find($transporter->id)->code === "$transporterEdit->code", 'Transporter not updated after patch request');

    }

    /**
     * DELETE api/transporters
     *
     * @test
     * @return void
     */
    public function users_with_permission_can_delete_transporter()
    {
        $transporter = Transporter::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $user->givePermissionTo('delete transporter');
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/transporters/$transporter->id");
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => [
                'message'
            ]
        ]);
        $this->assertTrue(Transporter::find($transporter->id) === null, 'Transporter not deleted after delete request');

    }

    /**
     * DELETE api/transporters
     *
     * @test
     * @return void
     */
    public function users_without_permission_cannot_delete_transporter()
    {
        $transporter = Transporter::factory()->create();
        $user = User::find(User::factory()->create()->id);
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/transporters/$transporter->id");
        $response->assertForbidden();

    }
}
