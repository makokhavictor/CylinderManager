<?php

namespace App\Http\Controllers;

use App\Events\PasswordResetEvent;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Resources\ForgotPasswordResource;
use App\Http\Resources\PasswordResetResource;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use AWS;
use DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function destroy()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            'headers' => [
                'message' => 'Successfully logged out'
            ]
        ]);
    }

    public function update(PasswordUpdateRequest $request)
    {

        if ($request->get('phone')) {
            $otp = Otp::generate($request->get('phone'), 'reset-password', 6, 60);
            $user = User::where('phone', $request->get('phone'))->first();

        } else {
            $otp = Otp::generate($request->get('email'), 'reset-password', 6, 60);
            $user = User::where('email', $request->get('email'))->first();
        }

        PasswordResetEvent::dispatch($otp, $user);

        return response()->json(ForgotPasswordResource::make($otp));

    }

    public function resetPassword(PasswordResetRequest $request)
    {

        $user = User::where('phone', $request->get('identifier'))->orWhere('email', $request->get('identifier'))->first();
        $validateOtp = Otp::validate($request->get('identifier'), $request->get('token'), 'reset-password');
        if ($validateOtp->status === false) {
            abort(401, $validateOtp->message);

        }

        return response()->json(PasswordResetResource::make($user));

    }

    private function updatePassword($user, $request) {
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return response()->json([
            'headers' => [
                'message' => 'Successfully updated password'
            ]
        ]);
    }

    public function passwordChange(PasswordChangeRequest $request)
    {

        $user = User::find(\auth()->id());
        if ($request->get('oldPassword') && Hash::check($request->get('oldPassword'), $user->password)) {
            return $this->updatePassword($user, $request);
        }

        if ($request->get('oldPassword') && !Hash::check($request->get('oldPassword'), $user->password)) {
            abort(401, 'Invalid old password');
        }


        $emailIdentifier = DB::table('otps')
            ->where('identifier', $user->email)
            ->where('updated_at', '>', now()->subHours(24))
            ->where('valid', false)->select('id', 'updated_at', 'identifier')->get();

        $phoneIdentifier = DB::table('otps')
            ->where('identifier', $user->phone)
            ->where('updated_at', '>', now()->subHours(24))
            ->where('valid', false)->select('id', 'updated_at', 'identifier')->get();

        $unexpiredOtpSize = sizeof(array_merge($emailIdentifier->toArray(), $phoneIdentifier->toArray()));
        if ($unexpiredOtpSize < 1) {
            abort(401, 'Invalid or expired token');
        }

        return $this->updatePassword($user, $request);
    }

}
