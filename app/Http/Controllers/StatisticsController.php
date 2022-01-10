<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function dashboardSummary()
    {
        return response()->json(['data' => [
            'depotsCount' => Depot::count(),
            'transportersCount' => Transporter::count(),
            'dealersCount' => Dealer::count(),
        ]]);
    }
}
