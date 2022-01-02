<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;

class CanisterStatisticsController extends Controller
{
    public function depots(Depot $depot)
    {
        return [
            'data' => [
                'canisters' => [
                    'filled' => $depot->receivedCanisterLogs()
                        ->where('filled', true)
                        ->where('defective', false)
                        ->whereNull('released_at')
                        ->count(),
                    'empty' => $depot->receivedCanisterLogs()
                        ->where('filled', false)
                        ->where('defective', false)
                        ->whereNull('released_at')
                        ->count(),
                    'defective' => $depot->receivedCanisterLogs()
                        ->where('defective', true)
                        ->whereNull('released_at')
                        ->count(),
                ]
            ]
        ];
    }

    public function transporters(Transporter $transporter)
    {
        return [
            'data' => [
                'canisters' => [
                    'filled' => $transporter->receivedCanisterLogs()
                        ->where('filled', true)
                        ->where('defective', false)
                        ->whereNull('released_at')
                        ->count(),
                    'empty' => $transporter->receivedCanisterLogs()
                        ->where('filled', false)
                        ->where('defective', false)
                        ->whereNull('released_at')
                        ->count(),
                    'defective' => $transporter->receivedCanisterLogs()
                        ->where('defective', true)
                        ->whereNull('released_at')
                        ->count(),
                ]
            ]
        ];
    }

    public function dealers(Dealer $dealer)
    {
        return [
            'data' => [
                'canisters' => [
                    'filled' => $dealer->receivedCanisterLogs()
                        ->where('filled', true)
                        ->where('defective', false)
                        ->whereNull('released_at')
                        ->count(),
                    'empty' => $dealer->receivedCanisterLogs()
                        ->where('filled', false)
                        ->where('defective', false)
                        ->whereNull('released_at')
                        ->count(),
                    'defective' => $dealer->receivedCanisterLogs()
                        ->where('defective', true)
                        ->whereNull('released_at')
                        ->count(),
                ]
            ]
        ];
    }
}
