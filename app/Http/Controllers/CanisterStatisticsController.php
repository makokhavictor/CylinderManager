<?php

namespace App\Http\Controllers;

use App\Models\Depot;

class CanisterStatisticsController extends Controller
{
    public function index(Depot $depot)
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
}
