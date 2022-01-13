<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier', 'token', 'validity', 'usage'
    ];

    public static function generate(string $identifier, string $usage = 'confirm-transaction', int $digits = 4, int $validity = 10 )
    {
        self::where('identifier', $identifier)->where('valid', true)->where('usage', $usage)->delete();
        $token = str_pad(self::generatePin($digits), $digits, '0', STR_PAD_LEFT);

        if (config('mail')['mailers']['smtp']['host'] === 'smtp.mailtrap.io') {
            return self::create([
                'identifier' => $identifier,
                'token' => '123456',// TODO remove in production
                'validity' => $validity,
                'usage' => $usage
            ]);
        }

        return self::create([
            'identifier' => $identifier,
            'token' => $token,
            'validity' => $validity,
            'usage' => $usage
        ]);

    }

    /**
     * @param string $identifier
     * @param string $token
     * @return mixed
     */
    public static function validate(string $identifier, string $token, string $usage = 'confirm-transaction') : object
    {
        $otp = self::where('identifier', $identifier)->where('token', $token)->where('usage', $usage)->first();

        if ($otp == null) {
            return (object)[
                'status' => false,
                'message' => 'OTP does not exist'
            ];
        } else {
            if ($otp->valid == true) {
                $carbon = new Carbon();
                $now = $carbon->now();
                $validity = $otp->created_at->addMinutes($otp->validity);

                if (strtotime($validity) < strtotime($now)) {
                    $otp->valid = false;
                    $otp->save();

                    return (object)[
                        'status' => false,
                        'message' => 'OTP Expired'
                    ];
                } else {
                    $otp->valid = false;
                    $otp->save();

                    return (object)[
                        'status' => true,
                        'message' => 'OTP is valid'
                    ];
                }
            } else {
                return (object)[
                    'status' => false,
                    'message' => 'OTP is not valid'
                ];
            }
        }
    }

    /**
     * @param int $digits
     * @return string
     */
    private static function generatePin($digits = 4)
    {
        // TODO-production remove line
        if (env('MAIL_HOST') === 'smtp.mailtrap.io') {
            return '123456';
        }
        $i = 0;
        $pin = "";

        while ($i < $digits) {
            $pin .= mt_rand(0, 9);
            $i++;
        }

        return $pin;
    }
}
