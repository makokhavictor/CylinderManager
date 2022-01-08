<?php

namespace Tests\Feature;

use App\Mail\PasswordResetMail;
use App\Models\Depot;
use App\Models\Otp;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(User::factory()->create()->id);
    }

    /**
     * GET api/oauth/user
     * @group auth
     * @test
     */
    public function auth_users_can_get_their_details()
    {
        $this->actingAs($this->user, 'api')
            ->get('api/oauth/user')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'firstName',
                    'lastName',
                    'phone',
                    'createdAt',
                    'profileDescription',
                    'emailVerified',
                    'phoneVerified',
                    'profilePictureLink',
                ]
            ]);
    }

    /**
     * GET api/oauth/user
     * @group auth
     * @test
     */
    public function depot_users_can_get_their_depot_user_id()
    {
        $depot = Depot::find(Depot::factory()->create()->id);
        $user = User::find(User::factory()->create()->id);
        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
        $user->assignRole('Depot User');
        $response = $this->actingAs($user, 'api')
            ->get('api/oauth/user');
        $response->assertJsonFragment(['roles' => ['Depot User']]);
        $response->assertSee(['permissions']);
        $response->assertJsonStructure([
            'data' => ['stationSpecificRoles' => [['roleId', 'roleName' , 'depotId', 'depotName', 'permissions' => [['id', 'permissionName']]]]]
        ]);
        $response->assertJsonFragment(['depotId' => $depot->id]);
    }

    /**
     * GET api/oauth/user
     * @group auth
     * @test
     */
    public function transporter_users_can_get_their_transporter_id()
    {

        $depot = Depot::find(Depot::factory()->create()->id);
        $user = User::find(User::factory()->create()->id);
        $depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Transporter User')->first()->id ]);

        $user->assignRole('Transporter User');
        $this->actingAs($user, 'api')
            ->get('api/oauth/user')
            ->assertJsonFragment(['roles' => ['Transporter User']]);
    }

    /**
     * GET api/oauth/revoke
     * @group auth
     * @test
     */
    public function user_can_logout()
    {
        Artisan::call('passport:install');
        $user = User::factory()->create();
        $token = 'Bearer ' . User::find($user->id)->createToken('Personal Access Token', ['*'])->accessToken;
        $this->getJson('api/oauth/revoke', ['Authorization' => $token])
            ->assertOk()
            ->assertJsonStructure(['headers' => ['message']]);
    }

    /**
     * GET api/oauth/revoke
     * @group auth
     * @test
     */
    public function users_without_token_cannot_call_logout()
    {
        Artisan::call('passport:install');
        $this->getJson('api/oauth/revoke')
            ->assertUnauthorized();
    }

    /**
     * POST api/oauth/forgot-password
     * @group auth
     * @test
     */

    public function email_or_phone_required_while_resetting_password()
    {
        $response = $this->postJson('api/oauth/forgot-password', []);
        $response->assertUnprocessable();

    }


    /**
     * POST api/oauth/forgot-password
     * @group auth
     * @test
     */

    public function user_can_request_otp_via_email_to_reset_password()
    {

        Mail::fake();
        $user = User::factory()->create();
        $response = $this->postJson('api/oauth/forgot-password', [
            'email' => $user->email
        ]);
        $response->assertOk();
        $response->assertJsonStructure(['data' => ['identifier'], 'headers' => ['message']]);
        Mail::assertSent(PasswordResetMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

    }

    /**
     * POST api/oauth/forgot-password
     * @group auth
     * @test
     */

    public function valid_phone_required_while_resetting_password()
    {
        $response = $this->postJson('api/oauth/forgot-password', ['phone' => 'Invalid Phone Number']);
        $response->assertUnprocessable();

    }

    /**
     * POST api/oauth/reset-password
     * @group auth
     * @test
     */

    public function user_can_reset_password_using_otp()
    {
        $user = User::factory()->create();
        $otp = Otp::factory()->state(['valid' => true, 'usage' => 'reset-password', 'identifier' => $user->phone])->create();
        $response = $this->postJson('api/oauth/reset-password', [
            'identifier' => $user->phone,
            'token' => $otp->token
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['access_token', 'token_type']
        ]);
    }

    /**
     * POST api/oauth/reset-password
     * @group auth
     * @test
     */

    public function invalid_token_returns_unauthenticated()
    {
        $user = User::factory()->create();
        $otp = Otp::factory()->state(['valid' => true, 'usage' => 'reset-password', 'identifier' => $user->phone])->create();
        $response = $this->postJson('api/oauth/reset-password', [
            'identifier' => $user->phone,
            'token' => $otp->token * 2
        ]);
        $response->assertStatus(401);
    }

    /**
     * POST api/oauth/reset-password
     * @group auth
     * @test
     */

    public function expired_token_returns_unauthenticated()
    {
        $user = User::factory()->create();
        $otp = Otp::factory()->state([
            'valid' => true,
            'validity' => 60,
            'usage' => 'reset-password',
            'identifier' => $user->phone,
            'created_at' => Carbon::now()->addMinutes(-70)
        ])->create();
        $response = $this->postJson('api/oauth/reset-password', [
            'identifier' => $user->phone,
            'token' => $otp->token
        ]);
        $response->assertStatus(401);
    }

    /**
     * POST api/oauth/reset-password
     * @group auth
     * @test
     */

    public function used_token_returns_unauthenticated()
    {
        $user = User::factory()->create();
        $otp = Otp::factory()->state([
            'valid' => false,
            'validity' => 60,
            'usage' => 'reset-password',
            'identifier' => $user->phone,
        ])->create();
        $response = $this->postJson('api/oauth/reset-password', [
            'identifier' => $user->phone,
            'token' => $otp->token
        ]);
        $response->assertStatus(401);
    }

    /**
     * POST api/oauth/password-change
     * @group auth
     * @test
     */

    public function user_can_change_password_after_confirming_otp_within_one_day()
    {
        $newPassword = $this->faker->password;
        $user = User::find(User::factory()->create()->id);
        Otp::factory()->state([
            'valid' => false,
            'validity' => 60,
            'usage' => 'reset-password',
            'identifier' => $user->phone,
            'created_at' => Carbon::now()->subHours(20),
            'updated_at' => Carbon::now()->subHours(20)
        ])->create();
        $response = $this->actingAs($user, 'api')
            ->postJson('api/oauth/password-change', [
                'password' => $newPassword,
                'passwordConfirmation' => $newPassword
            ]);
        $response->assertStatus(200);
    }

    /**
     * POST api/oauth/password-change
     * @group auth
     * @test
     */

    public function user_cannot_change_password_after_confirming_otp_not_within_one_day()
    {
        $newPassword = $this->faker->password;
        $user = User::find(User::factory()->create()->id);
        Otp::factory()->state([
            'valid' => false,
            'validity' => 60,
            'usage' => 'reset-password',
            'identifier' => $user->phone,
            'created_at' => Carbon::now()->subHours(25),
            'updated_at' => Carbon::now()->subHours(25)
        ])->create();
        $response = $this->actingAs($user, 'api')
            ->postJson('api/oauth/password-change', [
                'password' => $newPassword,
                'passwordConfirmation' => $newPassword
            ]);
        $response->assertUnauthorized();
    }

    /**
     * POST api/oauth/password-change
     * @group auth
     * @test
     */

    public function password_change_requires_confirmation_password()
    {
        $newPassword = $this->faker->password;
        $user = User::find(User::factory()->create()->id);
        Otp::factory()->state([
            'valid' => false,
            'validity' => 60,
            'usage' => 'reset-password',
            'identifier' => $user->phone,
            'created_at' => Carbon::now()->subHours(20),
            'updated_at' => Carbon::now()->subHours(20)
        ])->create();
        $response = $this->actingAs($user, 'api')
            ->postJson('api/oauth/password-change', [
                'password' => $newPassword,
                'passwordConfirmation' => $newPassword . 'Unmatched'
            ]);
        $response->assertUnprocessable();
    }

    /**
     * POST api/oauth/password-change
     * @group auth
     * @test
     */

    public function user_can_change_password_using_old_password()
    {
        $oldPassword = $this->faker->password;
        $newPassword = $this->faker->password;
        $user = User::find(User::factory()->state([
            'password' => bcrypt($oldPassword)
        ])->create()->id);
        $response = $this->actingAs($user, 'api')
            ->postJson('api/oauth/password-change', [
                'oldPassword' => $oldPassword,
                'password' => $newPassword,
                'passwordConfirmation' => $newPassword
            ]);
        $response->assertOk();
    }

    /**
     * POST api/oauth/password-change
     * @group auth
     * @test
     */

    public function user_cannot_change_password_using_invalid_old_password()
    {
        $oldPassword = $this->faker->password;
        $newPassword = $this->faker->password;
        $user = User::find(User::factory()->state([
            'password' => bcrypt($oldPassword)
        ])->create()->id);
        $response = $this->actingAs($user, 'api')
            ->postJson('api/oauth/password-change', [
                'oldPassword' => $oldPassword . 'unmatched',
                'password' => $newPassword,
                'passwordConfirmation' => $newPassword
            ]);
        $response->assertUnauthorized();
    }


}
